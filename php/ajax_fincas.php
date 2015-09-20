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
		$checked = "";
		$qry_lotes ='SELECT idlote, especie_ica, ano_plant, vol_ica_m3 FROM tbl_matriz_ica WHERE codfinca="'.$cod.'";';
		$res_lotes = mysql_query($qry_lotes);
		while($row_lotes = mysql_fetch_assoc($res_lotes)) {
			//autorizados true?
			if(isset($_POST['aut']) && $_POST['aut']){
				$js_fn = 'save_check("'.$cod.'", this)';
				$onclick = "onclick='".$js_fn."'";
				$qry_aut='SELECT * FROM tbl_lotes_autorizados INNER JOIN tbl_fincas ON tbl_fincas.fi_codigo = "'.$cod.'" AND tbl_lotes_autorizados.la_idlote = "'.$row_lotes['idlote'].'" AND tbl_lotes_autorizados.la_estado < 99;';
				$res_aut = mysql_query($qry_aut);
				$row_aut = mysql_fetch_assoc($res_aut);
				$cant_aut = mysql_num_rows($res_aut);
				//echo "<br>".$qry_aut."<br> resultados: ".$cant_aut;
				if($cant_aut>0){
					$checked = "checked";
				}else{
					$checked = "";
				}
			}else{
				$onclick="";
			}
			$item.='<label class=""><input '.$onclick.' type="checkbox" name="lotes[]" value="'.$row_lotes['idlote'].'" '.$checked.'>'.$row_lotes['idlote'].' - '.$row_lotes['especie_ica'].' ('.$row_lotes['ano_plant'].') Volumen: '.$row_lotes['vol_ica_m3'].' m<sup>3</sup></label><br>';
		}
		$res=true;
		$mes=$item;
				
		
		$response->res = $res;
		$response->mes = $mes;
		echo json_encode($response);

		$con->disconnect();

	}
	//consultamos fincas con sus respectivos lotes
	function get_fincas_lotes(){	
		$fun = new funciones();
		$msg = new messages();
		$response = new StdClass;

		/*recibimos variables*/
		$cod=$_POST["cod"];
		$lot=$_POST["lot"];

		$con = new con();
		$con->connect();

		/* ingresamos datos de la finca */
		$item="";
		$qry_lotes ='SELECT * FROM tbl_control_inventarios
						INNER JOIN tbl_fincas ON tbl_fincas.fi_id=tbl_control_inventarios.ci_fi_id 
						INNER JOIN tbl_lotes_autorizados ON tbl_lotes_autorizados.la_id = tbl_control_inventarios.ci_in_lote ;';
		$res_lotes = mysql_query($qry_lotes);
		
		while($row_res = mysql_fetch_assoc($res_lotes)) {
	        $item.='
	              <option value="'.$row_res["fi_id"].'">'.$row_res["fi_codigo"].'</option>
	        ';
	        $script.='';
	    }
	    $script.='});</script>';
		
		$html='
	        <select class="form-control valued" id="cod">
	          <option>Seleccione</option>
	          '.$item.'
	        </select>
	    ';

		$res=true;
		$mes=$item;
				
		
		$response->res = $res;
		$response->mes = $mes;
		echo json_encode($response);

		$con->disconnect();

	}
  //Cambiar lotes
	function cambiar_lote(){
		$fun = new funciones();
		$msg = new messages();
		$response = new StdClass;

		/*recibimos variables*/
		$evento=$_POST["e"];
		$lote=$_POST["l"];
		$finca=$_POST["f"];

		$con = new con();
		$con->connect();

		//traemos id de la finca
		$fi_id = $fun->get_id("fi_id","fincas","fi_codigo",$finca);
		
		if($evento=="save"){
			//creamos lote
			$values=$fi_id.", '".$lote."', ".$_SESSION["ses_id"].',1';
			if($fun->existe("lotes_autorizados", "la_fi_id", $fi_id, "AND la_idlote='".$lote."'")){
				$res=$fun->activar("lotes_autorizados", "la_fi_id", $fi_id, "AND la_idlote='".$lote."'");
				$mes=null;
			}else{
				$res=$fun->crear("lotes_autorizados", "la_fi_id, la_idlote, la_created, la_estado", $values);
				$mes=null;
			}
			
		}else{
			//preguntamos si existe el lote autorizado
			if($fun->existe("lotes_autorizados", "la_fi_id", $fi_id, "AND la_idlote='".$lote."'")){
				//Borramos el que existe (FULL)
				if($fun->borrar("lotes_autorizados", "la_fi_id", $fi_id, "AND la_idlote='".$lote."'")){
					$res=true;
					$mes=null;
				}else{
					$res=false;
					$mes=null;
				}
			}else{
					$res=false;
					$mes=null;
				}
		}

		$response->res = $res;
		$response->mes = $mes;
		echo json_encode($response);

		$con->disconnect();
	}
	//Borrar finca
	function remove_finca(){
		$fun = new funciones();
		$msg = new messages();
		$response = new StdClass;

		/*recibimos variables*/
		$finca=$_POST["finca"];
		if ($fun->borrar("fincas","fi_id",$finca)) {
			if($fun->borrar("inventario","in_fi_id",$finca)){
				if($fun->borrar("control_inventarios","ci_fi_id",$finca)){
					if($fun->borrar("lotes_autorizados","la_fi_id",$finca)){
						$res=true;
						$mes=$msg->get_msg("e004");
					}else{
					$res=false;
					$mes=$msg->get_msg("e016");}
				}else{
				$res=false;
				$mes=$msg->get_msg("e017");}
			}else{
			$res=false;
			$mes=$msg->get_msg("e018");}
		}else{
		$res=false;
		$mes=$msg->get_msg("e015");}

		
		$response->res = $res;
		$response->mes = $mes;
		echo json_encode($response);
	}

  //validamos si es una petición ajax
  if(isset($_POST['action']) && !empty($_POST['action'])) {
      $action = $_POST['action'];
      switch($action) {
          case 'save' : add_finca();break;
          case 'del_finca' : remove_finca();break;
          case 'get_lotes' : get_lotes();break;
          case 'get_fxl' : get_fincas_lotes();break;
          case 'change_lote_aut' : cambiar_lote();break;
      }
  }
?>