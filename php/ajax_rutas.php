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

	/**/$vol_inventario = $row_ci['ci_vol_ini'];
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
				$json.='{"id":'.$row_cond['pe_id'].', "nombre":"'.$row_cond['pe_nombre'].'", "capacidad":'.$row_cond['ve_capacidad_m3'].', "inicia": '.$start.'},';
			}

			//crear json_array
			//limpiar array 
			$json = trim($json, ",");
			$array['cond'] = json_decode('['.$json.']', true);
			//print_r($array["cond"]);

			//Generar lista
			$clave = array_search(111, array_column($array['cond'], 'inicia'));
			$cantidad = count($array['cond']);
				/*echo "clave: true , encontrado en: ".$clave;
				echo "<br> cantidad de conductores: ".$cantidad;
				echo "<br> inventario: ".$vol_inventario."m3";*/
				$html="";
				$turno=0;
				while ($vol_act > 0) {
					$past=0;
					for ($i=$clave; $i <= $cantidad; $i++) { 
						if($vol_act <= 0){break;}
						if($i==$cantidad && $past==0){$i=0;$past=1;}
						if($i==$cantidad && $past==1){$i=0;$past=2;}
						//if($past==1 && $i==$clave){break;}
						if($past==2 && $i==$clave){break;}
						$vol_act = $vol_act - $array['cond'][$i]["capacidad"];
						if($vol_act<=0){$vol_act=0;}
						$html.="<tr class='info'>";
						$html.='<td>'.$turno.' / past: '.$past.'</td>';
						$html.='<td>'.$array['cond'][$i]["nombre"].'</td>';
						$html.='<td>'.$array['cond'][$i]["capacidad"].'</td>';
						$html.='<td>'.$vol_act.'</td>';
						$html.='
						<td>
							<a href="#" class="btn btn-floating-mini btn-success" data-ripple-centered=""><i class="md md-save"></i></a>
							<a href="#" class="btn btn-floating-mini btn-info" data-ripple-centered=""><i class="md md-edit"></i></a>
						</td>';
						$html.="</tr>";
						$turno++;
						//echo "<br>[".$i."]: Past:[".$past."] => Nombre: ".$array['cond'][$i]["nombre"]. "volumen actual: ".$vol_act."m3";
					}
					if($past==2){break;}
				}

			$res=true;
			$mes=$html;	
		}else{
			$res=false;
			$mes=$msg->get_msg("e024");
		}
		
		//evacuar inventario (sugerir)

		
				
		$con->disconnect();
		
		$response->res = $res;
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

  //validamos si es una petición ajax
  if(isset($_POST['action']) && !empty($_POST['action'])) {
      $action = $_POST['action'];
      switch($action) {
          case 'save' : add_finca();break;
          case 'get_rutas' : get_modal_values();break;
          case 'get_turnos' : get_turnos_generados();break;
      }
  }
?>