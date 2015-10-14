<?php
session_start();
require("funciones.php");
require("messages.php");

$fun = new funciones();
if(!$fun->isAjax()){header ("Location: ../../mods/panel/panel.php");}

  //=============Definimos funciones===================
	//construimos los turnos según sea el inventario y los conductores
	function get_des(){	
		$fun = new funciones();
		$msg = new messages();
		$response = new StdClass;

		/*recibimos variables*/
		$f1 = $_POST["f1"];
		$f2 = $_POST["f2"];
		$fi = $_POST["fi"];

		$con = new con();
		$con->connect();

		//traer información del conductor segun sea la fecha
		$qry_des ='SELECT * FROM `tbl_despachos`
					INNER JOIN tbl_personas ON pe_id = de_pe_id
					INNER JOIN tbl_vehiculos ON ve_id = pe_ve_id
					INNER JOIN tbl_turnos ON tu_id = de_tu_id
					INNER JOIN tbl_inventario ON in_id = de_in_id
					INNER JOIN tbl_fincas ON fi_id=in_fi_id
					WHERE 
					fi_id = '.$fi.' AND
					de_timestamp BETWEEN "'.$f1.' 00:00:00" AND "'.$f2.' 23:59:59"
					AND de_estado = 2
					;';
		//echo $qry_des;
		$res_des = mysql_query($qry_des);
		$can_des = mysql_num_rows($res_des);
		$item="";
		$html="";
		$html_plain = '<div id="plain_html" style="display:none;">';

		$btn_export='
		<div class="btn-group">
		  <a href="" class="btn btn-primary"><i class="md md-file-download"></i> Exportar</a>
		  <a href="" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></a>
		  <ul class="dropdown-menu">
		    <li><a href="#" onClick="desc(1)">PDF</a></li>
		    <li class="divider"></li>
		    <li><a href="#" onClick="desc(2)">Word</a></li>
		    <li><a href="#" onClick="desc(3)">Excel</a></li>
		  </ul>
		</div>';
		
		$item.='<div class="list-group">';
		$item.='	<table class="table table-striped table-hover "><thead>';
		$item.='	<tr>
						<th>Resultados Generados</th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th style="text-align:right">'.$btn_export.'</th>
					</tr></thead><tbody>';
		$html_plain .= '
					<table><thead>
					<tr>
						<th>Id</th>
						<th>Nombre Conductor</th>
						<th>Placa vehiculo</th>
						<th>Fecha Salida</th>
						<th>Hora Salida</th>
						<th>Finca de Destino</th>
						<th>ICA Asignado</th>
					</tr></thead><tbody>
					';
		while($row_des = mysql_fetch_assoc($res_des)) {
			//fecha de salida
			$fecha = split(" ", $row_des['de_timestamp']);
			list($año, $mes, $dia) = split('[/.-]', $fecha[0]);

			//list-group
			$item.='<tr>';
			$item.='	<td><i title="Nombre" class="md md-person"></i> '.$row_des['pe_nombre'].'</td>';
			$item.='	<td title="Placa"><i class="md md-drive-eta"></i> '.$row_des['ve_placa'].'</td>';
			$item.='	<td title="Fecha Salida"><i class="md md-today"></i> '.$año."-".$mes."-".($dia+1).'</td>';
			$item.='	<td title="Hora Salida"><i class="md md-access-alarm"></i> '.$row_des['tu_hora_ini'].'</td>';
			$item.='	<td title="Finca"><i class="md md-place"></i> '.$row_des['fi_codigo'].'</td>';
			$item.='	<td title="ICA"><i class="md md-description"></i> '.$row_des['de_ica'].'</td>';
			$item.='</tr>';

			//html_plain
			$html_plain.='<tr>';
			$html_plain.='	<td>'.$row_des['de_id'].'</td>';
			$html_plain.='	<td>'.$row_des['pe_nombre'].'</td>';
			$html_plain.='	<td>'.$row_des['ve_placa'].'</td>';
			$html_plain.='	<td>'.$año."-".$mes."-".($dia+1).'</td>';
			$html_plain.='	<td>'.$row_des['tu_hora_ini'].'</td>';
			$html_plain.='	<td>'.$row_des['fi_codigo'].'</td>';
			$html_plain.='	<td>'.$row_des['de_ica'].'</td>';
			$html_plain.='</tr>';

		}
		$item.='</tbody></table></div>';
		$html_plain.='</tbody></table></div>';
		
		$html = $item.$html_plain;

		if ($res_des) {
			$res=true;
			$mes=$html;
		} else {
			$res=false;
			$mes=$msg->get_msg("e026");
		}
		
		$con->disconnect();
		
		$response->res = $res;
		$response->mes = $mes;
		echo json_encode($response);
	}

	function upd_despacho(){
		$fun = new funciones();
		$msg = new messages();
		$response = new StdClass;

		/*recibimos variables*/
		$de_id = $_POST['id'];
		$opt = $_POST['op'];

		switch ($opt) {
			case 1:	$estado=2; break;
			case 2:	$estado=3; break;
			case 3:	$estado=99; break;
		}

		$con = new con();
		$con->connect();

		//preguntamos si existe el despacho y si está sugerido
		$existe = $fun->existe("despachos","de_id",$de_id, "");
		if($existe){
			if($opt==1){
				$qry_des = 'SELECT * FROM tbl_despachos WHERE de_id='.$de_id.';';
				//echo "despachos: ".$qry_des;
				$arr_des = $fun->get_array($qry_des);
				
				//$fun->print_array($arr_des);
				

				//traemos inventario
				$qry_inv = 'SELECT * FROM tbl_inventario WHERE in_id ='.$arr_des[0]["de_in_id"].';';
				//echo "despachos: ".$qry_inv;
				$arr_inv = $fun->get_array($qry_inv);
				
				//$fun->print_array($arr_inv);
				
				//tomamos datos y los modificamos
				$inv_nuevo = $arr_inv[0]["in_mt_restante"]-$arr_des[0]['de_ve_capacidad_m3'];
				//echo "<br>nuevo inventario: ".$inv_nuevo;
				//realizar la actualización
				$upd_vol = $fun->actualizar("inventario", "in_mt_restante =".$inv_nuevo, "in_id = ".$arr_inv[0]["in_id"]);
			}

			$res_upd = $fun->actualizar("despachos", "de_estado=".$estado, "de_id=".$de_id);
			if ($res_upd) {
				$res = true;
				$mes = $msg->get_msg('e004');
			} else {
				$res = false;
				$mes = $msg->get_msg('e027');
			}
		}else{
			$res = false;
			$mes = $msg->get_msg('e028');
		}

		$con->disconnect();
		
		$response->res = $res;
		$response->mes = $mes;
		echo json_encode($response);

	}

	function gen_report(){
		$fun = new funciones();
		$msg = new messages();
		$response = new StdClass;

		/* Enviamos datos por Session */
		$_SESSION['report']['o'] = $_POST['o'];
		$_SESSION['report']['c'] = $_POST['c'];
		$_SESSION['report']['t'] = $_POST['t'];
		$_SESSION['report']['n'] = $_POST['o']."_".date('YmdGis');

		$response->res = true;
		echo json_encode($response);
	}

  //validamos si es una petición ajax
  if(isset($_POST['action']) && !empty($_POST['action'])) {
      $action = $_POST['action'];
      switch($action) {
          case 'get_info_des' : get_des();break;
          case 'update_delivery' : upd_despacho();break;
          case 'send_report' : gen_report();break;
      }
  }
?>