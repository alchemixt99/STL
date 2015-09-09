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
		$nombre="";

		if($cod==""){
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
					$qry ="INSERT INTO tbl_fincas (fi_codigo, fi_created, fi_estado)
							VALUES ('".$cod."',".$_SESSION["ses_id"].",1);";

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
	//consultamos lotes de la finca desde la matriz ica
	function get_lotes(){	
		$fun = new funciones();
		$msg = new messages();
		$response = new StdClass;

		/*recibimos variables*/
		$cod=$_POST["cod"];

		$con = new con();
		$con->connect();

		/* ingresamos datos de la finca */
		$item="";
		$qry_lotes ='SELECT idlote, especie_ica, ano_plant, vol_ica_m3 FROM tbl_matriz_ica WHERE codfinca="'.$cod.'";';
		$res_lotes = mysql_query($qry_lotes);
		while($row_lotes = mysql_fetch_assoc($res_lotes)) {
			$item.='<label class=""><input type="checkbox" name="lotes[]" value="'.$row_lotes['idlote'].'">'.$row_lotes['idlote'].' - '.$row_lotes['especie_ica'].' ('.$row_lotes['ano_plant'].') Volumen: '.$row_lotes['vol_ica_m3'].' m<sup>3</sup></label><br>';
		}
		$res=true;
		$mes=$item;
				
		
		$response->res = $res;
		$response->mes = $mes;
		echo json_encode($response);

		$con->disconnect();

	}

  //validamos si es una petición ajax
  if(isset($_POST['action']) && !empty($_POST['action'])) {
      $action = $_POST['action'];
      switch($action) {
          case 'save' : add_finca();break;
          case 'get_lotes' : get_lotes();break;
      }
  }
?>