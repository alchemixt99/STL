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
					de_timestamp BETWEEN "'.$f1.' 00:00:00" AND "'.$f2.' 23:59:59"
					AND de_estado = 2
					;';
		//echo $qry_des;
		$res_des = mysql_query($qry_des);
		$can_des = mysql_num_rows($res_des);
		$item="";
		$html="";
		while($row_des = mysql_fetch_assoc($res_des)) {
			//botones
			$b1 = '<div class="btn btn-floating-mini btn-primary" title="Confirmar" onclick="change(1,'.$row_des['de_id'].')" ><i class="md md-check"></i></div>';
			$b2 = '<div class="btn btn-floating-mini btn-warning" title="Cancelar" onclick="change(2,'.$row_des['de_id'].')" ><i class="md md-warning"></i></div>';
			$b3 = '<div class="btn btn-floating-mini btn-danger" title="Borrar" onclick="change(3,'.$row_des['de_id'].')" ><i class="md md-delete"></i></div>';
			$t1 = '<div class="btn btn-flat btn-warning">Cancelado</div>';
			$t2 = '<div class="btn btn-flat btn-danger">Borrado</div>';

			switch ($row_des["de_estado"]) {
				case 1: $btnset=$b1.$b3; break;//sugerido
				case 2: $btnset=$b2.$b3; break;//autorizado
				case 3: $btnset=$t1; break;//cancelado
				case 99: $btnset=$t2; break;//borrado
			}

			//list-group
			$item.='
					<div class="list-group">
					  <a class="list-group-item" >
					    <h4 class="list-group-item-heading">'.$row_des['pe_nombre'].'</h4>
					    <p class="list-group-item-text">';
			$item.='	<table class="table table-striped table-hover "><tbody><tr>';
			$item.='	<td><i class="md md-drive-eta"></i> '.$row_des['ve_placa'].'</td>';
			$item.='	<td><i class="md md-access-alarm"></i> '.$row_des['tu_hora_ini'].'</td>';
			$item.='	<td><i class="md md-place"></i> '.$row_des['fi_codigo'].'</td>';
			$item.='	<td><i class="md md-description"></i> <input type="text"></td>';
			$item.='	<td>'.$btnset.'</td>';
			$item.='	</tr></tbody></table>';
			$item.='
					    </p>
					  </a>
					</div>';
		}

		
		$html = $item;

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


  //validamos si es una petición ajax
  if(isset($_POST['action']) && !empty($_POST['action'])) {
      $action = $_POST['action'];
      switch($action) {
          case 'get_info_des' : get_des();break;
          case 'update_delivery' : upd_despacho();break;
      }
  }
?>