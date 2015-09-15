<?php
session_start();
require("funciones.php");
require("messages.php");

$fun = new funciones();
if(!$fun->isAjax()){header ("Location: ../../mods/panel/panel.php");}

  //=============Definimos funciones===================
	//agregar fincas
	function add_finca(){	
		$fun = new funciones();
		$msg = new messages();
		$response = new StdClass;

		/*recibimos variables*/
		$cod=$_POST["cod"];
		$nombre=$_POST["nombre"];

		if($nombre==""){
			$res=false;
			$mes=$msg->get_msg("e005");
		}else
		{
			$con = new con();
			$con->connect();

			/* verificamos que exista la finca en la matriz importada desde excel*/
			$res_finca = $fun->existe("matriz_ica","codfinca",$cod);

			/* verificamos que no esté registrada en la tabla de fincas*/
			$res_existe = $fun->existe("fincas","fi_codigo",$cod);
			if($res_finca){
				if(!$res_existe){
					/* ingresamos datos de la finca */
					$qry ="INSERT INTO tbl_fincas (fi_codigo, fi_nombre, fi_created, fi_estado)
							VALUES ('".$cod."','".$nombre."',".$_SESSION["ses_id"].",1);";

					$resp = mysql_query($qry);
					if(!$resp){
						$res=false;
						$mes=$msg->get_msg("e003");
					}else{
						//Si la insercción fué correcta, traemos el id de la finca y lo asociaremos a cada lote que se autorizó
						$qry_fi="SELECT fi_id, fi_codigo FROM tbl_fincas WHERE fi_codigo='".$cod."' ORDER BY fi_id DESC LIMIT 1;";
						$res_fi=mysql_query($qry_fi);
						if($row_fi=mysql_fetch_assoc($res_fi)){
							//echo "<br> ultima finca: ".$row_fi['fi_id']."<br>";
							//echo "<br> query finca: ".$qry_fi."<br>";
							//validamos integridad de los lotes
							if(isset($_POST['arr_lotes'])){
								//hacemos insercción por cada lote con el codfinca								
								foreach ($_POST['arr_lotes'] as $key => $value) {
									$qry_lotes='INSERT INTO tbl_lotes_autorizados (la_fi_id, la_idlote, la_created, la_estado)
													VALUES('.$row_fi['fi_id'].', "'.$value.'", '.$_SESSION["ses_id"].',1);';

									//echo "<br> Insert lote: ".$qry_lotes."<br>";



									$resp_lotes = mysql_query($qry_lotes);
								}
								if(!$resp_lotes){
									$res=false;
									$mes=$msg->get_msg("e003");
								}else{
									$res=true;
									$mes=$msg->get_msg("e004");
								}
							}else{
								$res=true;
								$mes=$msg->get_msg("e004");
							}
						}else{
							$res=false;
							$mes=$msg->get_msg("e003");
						}
					}	
				}else{
					$res=false;
					$mes=$msg->get_msg("e007");
				}
			}else{
				$res=false;
				$mes=$msg->get_msg("e006");
			}

			
		}
		$response->res = $res;
		$response->mes = $mes;
		echo json_encode($response);

		$con->disconnect();

	}
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

		/* PILA DE TURNOS */
		$turnos = array();

		//Generamos turnos según inventario seleccionado
		//buscamos inventario
		$qry_inv = 'SELECT * FROM tbl_inventario WHERE in_estado = 1 AND in_id = '.$cod_inv.';';
		$res_inv = mysql_query($qry_inv);
		$html ="";
		$row_inv = mysql_fetch_assoc($res_inv);
		$vol_inv = $row_inv['in_mt_cubico'];

		//listamos conductores (aplicando restricciones)
		$qry_cond = 'SELECT pe_nombre, pe_cedula, ve_placa, ve_capacidad_m3 FROM tbl_personas 
					INNER JOIN tbl_vehiculos ON ve_id = pe_ve_id
					WHERE pe_estado = 1
					AND pe_f1 = '.$finca.'
					OR pe_f2 = '.$finca.'
					OR pe_f3 = '.$finca.' ORDER BY pe_timestamp ASC;';
		$res_cond = mysql_query($qry_cond);
		$i=0;
		while($row_cond = mysql_fetch_assoc($res_cond)){
			$cond_lista[$i]=$row_cond;
			$i++;
		}
		//terminamos de listar conductores

		//asignamos turnos mientras se evacua el inventario
		$turno=1;
		$positivo=true;
		while($vol_inv>0){
			$cond_cant = count($cond_lista);
			for ($i=0; $i < $cond_cant; $i++) { 
				if($positivo==true){
					$vol_restante = $vol_inv-$cond_lista[$i]['ve_capacidad_m3'];
					$html.="<tr class='info'>";
					$html.='<td>'.$turno.'</td>';
					$html.='<td>'.$cond_lista[$i]['pe_nombre'].'</td>';
					$html.='<td>'.$cond_lista[$i]['ve_capacidad_m3'].'</td>';
					$html.='<td>'.$vol_restante.'</td>';
					$html.='
					<td>
						<a href="#" class="btn btn-floating-mini btn-success" data-ripple-centered=""><i class="md md-save"></i></a>
						<a href="#" class="btn btn-floating-mini btn-info" data-ripple-centered=""><i class="md md-edit"></i></a>
					</td>';
					$html.="</tr>";
					if($vol_restante<=0) {
						$vol_inv=0;
						$positivo=false;
						$i=$cond_cant;
					}else if($vol_restante>0){
						$vol_inv = $vol_restante;
					}
					$turno++;
				}
			}
		}

		$res=true;
		$mes=$html;
				
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