<?php
session_start();
require("funciones.php");
require("messages.php");

$fun = new funciones();
if(!$fun->isAjax()){header ("Location: ../../mods/panel/panel.php");}

  //=============Definimos funciones===================
	//construimos los turnos según sea el inventario y los conductores
	function get_turnos_generados(){	
		$fun = new funciones();
		$msg = new messages();
		$response = new StdClass;

		/*recibimos variables*/
		$cod_inv=$_POST["cod_inv"];
		$finca = $_POST["fin"];

		$con = new con();
		$con->connect();

		//traer inventario
		$qry_inv = 'SELECT * FROM tbl_inventario WHERE in_id='.$cod_inv.';';
		$res_inv = mysql_query($qry_inv);
		$row_inv = mysql_fetch_assoc($res_inv);


		//traer control de inventario
		$qry_ci = 'SELECT * FROM tbl_control_inventarios WHERE ci_fi_id='.$row_inv['in_fi_id'].' AND ci_in_lote = '.$row_inv['in_lote'].';';
		$res_ci = mysql_query($qry_ci);
		$row_ci = mysql_fetch_assoc($res_ci);

	/**/$vol_inventario = $row_inv['in_mt_cubico'];
		$vol_act = $vol_inventario;


		//traer conductores
		$fi_id = $fun->get_custom("SELECT fi_codigo FROM tbl_fincas WHERE fi_id=".$finca.";");
		$qry_cond = 'SELECT pe_id, pe_nombre, pe_cedula, ve_placa, ve_capacidad_m3 FROM tbl_personas 
			INNER JOIN tbl_vehiculos ON ve_id = pe_ve_id
			WHERE pe_estado = 1 AND
			pe_tipo<>1 AND 
			pe_f1 = "'.$fi_id.'"
			OR pe_f2 = "'.$fi_id.'"
			OR pe_f3 = "'.$fi_id.'" ORDER BY pe_timestamp ASC;';
		$res_cond = mysql_query($qry_cond);
		$cant_cond = mysql_num_rows($res_cond);
		if($cant_cond>0){
			$json ="";
			$i=0;
			while ($row_cond=mysql_fetch_assoc($res_cond)) {
				if($row_inv['in_pe_id']==$row_cond['pe_id']){$start=111;}else{$start=0;}
				$json.='{"id":'.$row_cond['pe_id'].', "nombre":"'.$row_cond['pe_nombre'].'", "capacidad":'.$row_cond['ve_capacidad_m3'].', "inicia": '.$start.', "finca":'.$finca.', "placa": "'.$row_cond['ve_placa'].'"},';
			}

			//crear json_array
			//limpiar array 
			$json = trim($json, ",");
			$array['cond'] = json_decode('['.$json.']', true);
			//print_r($array["cond"]);

			//Generar lista
			$clave = array_search(111, array_column($array['cond'], 'inicia'));
			if($clave==""){$clave=0;}
			$cantidad = count($array['cond']);
				$html="";
				$turno=10;
				while ($vol_act > 0) {
					$past=0;
					for ($i=$clave; $i <= $cantidad; $i++) { 
						$turno_hora = $fun->get_custom("SELECT tu_hora_ini FROM tbl_turnos WHERE tu_id=".$turno.";");
						if($vol_act <= 0){break;}
						if($i==$cantidad && $past==0){$i=0;$past=1;}
						if($i==$cantidad && $past==1){$i=0;$past=2;}
						//if($past==1 && $i==$clave){break;}
						if($past==2 && $i==$clave){break;}
						$vol_act = $vol_act - $array['cond'][$i]["capacidad"];
						if($vol_act<=0){$vol_act=0;}
						$values=$turno.",".$array['cond'][$i]["id"].",".$cod_inv.",".$array['cond'][$i]["capacidad"];
						//$res_turno=$fun->crear("despachos", "de_tu_id, de_pe_id, de_in_id, de_vol, de_created, de_estado", $values);

						/*Traemos turnos*/
						/*if($res_turno){
							$qry_turnos = "SELECT * FROM tbl_turnos WHERE de_in_id=".$cod_inv.";";
							$res_turnos = mysql_query($qry_turnos);
							$can_turnos = mysql_num_rows($res_turnos);
							while ($row_turnos=mysql) {
								# code...
							}
						}*/

						$html.="<tr class='info' id='".$turno."'>";
						$html.='<td>'.$turno_hora.'</td>';
						$html.='<td>'.$array['cond'][$i]["nombre"].'</td>';
						$html.='<td>'.$array['cond'][$i]["placa"].'</td>';
						$html.='<td>'.$array['cond'][$i]["capacidad"].' m<sup>3</sup></td>';
						$html.='<td>'.$vol_act.' m<sup>3</sup></td>';
						$html.='
						<td>
							<div onclick="guardar_turno('.$values.', this)" class="btn btn-floating-mini btn-success" data-ripple-centered=""><i class="md md-save"></i></div>
							<div class="btn btn-floating-mini btn-info" data-ripple-centered=""><i class="md md-edit"></i></div>
							<div class="btn btn-floating-mini btn-danger" data-ripple-centered=""><i class="md md-delete"></i></div>
						</td>';
						$html.="</tr>";
						$turno++;
					}
					if($past==2){break;}
				}

			$res=true;
			$mes=$html;	
			$input = $vol_act;
		}else{
			$res=false;
			$mes=$msg->get_msg("e024");
			$input=0;
		}

		$con->disconnect();
		
		$response->res = $res;
		$response->vol = $input;
		$response->mes = $mes;
		echo json_encode($response);
	}

	//construimos los valores a cargar en el modal
	function get_modal_values(){	
		$fun = new funciones();
		$msg = new messages();
		$response = new StdClass;

		/*recibimos variables*/
		$cod=$_POST["cod"];
		$lot=$_POST["lot"];

		$con = new con();
		$con->connect();

		/* ingresamos datos de la finca */
		$item="<option>Seleccione Inventario</option>";
		$qry_lotes ='SELECT * FROM tbl_inventario AS I
					INNER JOIN tbl_fincas AS F ON F.fi_id=I.in_fi_id
					INNER JOIN tbl_lotes_autorizados AS L ON L.la_id=I.in_lote
					WHERE in_fi_id ='.$cod.' AND in_lote = '.$lot.';';
		//echo $qry_lotes;
		$res_lotes = mysql_query($qry_lotes);
		while($row_lotes = mysql_fetch_assoc($res_lotes)) {
			$item.='<option value="'.$row_lotes['in_id'].'">Finca: '.$row_lotes['fi_codigo'].' - Lote: '.$row_lotes['la_idlote'].' ('.$row_lotes['in_mt_cubico'].' m<sup>3</sup>) </option>';
		}
		$scr='
		<script>
		  //acción al cambiar el select id=inv
	      $("#combo_inv").on("change", function(){
      		$("#progress").fadeIn();
	        $.ajax({      
	          url: "../../php/ajax_rutas.php",     
	          dataType: "json",     
	          type: "POST",     
	          data: { 
	                  action: "get_turnos",
	                  cod_inv: $("#combo_inv").val(),
	                  fin: $("#cod_finca").val()
	                },
	          success: function(data){    
	            if(data.res==true){
	              $("#turnos_box").fadeIn();
	              $("#turnos_box").html(data.mes);
      			  $("#progress").fadeOut();
	            }
	          }
	        });
	      });

		</script>';
		$html = '<select class="form-control" id="combo_inv">
	            '.$item.'
	             </select>';
		$res=true;
		$mes=$scr.$html;
				
		$con->disconnect();
		
		$response->res = $res;
		$response->mes = $mes;
		echo json_encode($response);
	}

	function add_route(){
		$fun = new funciones();
		$msg = new messages();
		$response = new StdClass;

		/*recibimos variables*/
		$turno = $_POST['turno'];
     	$condu = $_POST['condu'];
    	$inven = $_POST['inven'];
    	$capac = $_POST['capac'];

		$con = new con();
		$con->connect();

		$values=$turno.",".$condu.",".$inven.",".$capac.",".$_SESSION["ses_id"].",1";
		$res=$fun->crear("despachos", "de_tu_id, de_pe_id, de_in_id, de_vol, de_created, de_estado", $values);

		$mes=null;
				
		$con->disconnect();
		
		$response->res = $res;
		$response->mes = $mes;
		echo json_encode($response);

	}

  //validamos si es una petición ajax
  if(isset($_POST['action']) && !empty($_POST['action'])) {
      $action = $_POST['action'];
      switch($action) {
          case 'save' : add_finca();break;
          case 'get_rutas' : get_modal_values();break;
          case 'save_rutas' : add_route();break;
          case 'get_turnos' : get_turnos_generados();break;
      }
  }
?>