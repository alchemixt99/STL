<?php
session_start();
require("funciones.php");
require("messages.php");

$fun = new funciones();
if(!$fun->isAjax()){header ("Location: ../../mods/panel/panel.php");}

  //=============Definimos funciones===================
	//agregar fincas
	function add_persona(){	
		$fun = new funciones();
		$msg = new messages();
		$response = new StdClass;

		/*recibimos variables*/
		$tipo = $_POST['tipo'];
		$nombre = $_POST['nombre'];
		$ced = $_POST['ced'];
		$lic = $_POST['lic'];
		$lic_v = $_POST['lic_v'];
		$dir = $_POST['dir'];
		$tel = $_POST['tel'];
		$cel = $_POST['cel'];
		$f1 = $_POST['f1'];
		$f2 = $_POST['f2'];
		$placa = $_POST['placa'];

		if($tipo==1){$placa="0";}

		if($nombre==""){
			$res=false;
			$mes=$msg->get_msg("e005");
		}else
		{
			$con = new con();
			$con->connect();

			/* verificamos que no esté registrado en la tabla de personas*/
			$res_existe = $fun->existe("personas","pe_cedula",$ced);
			if(!$res_existe){
				/* ingresamos datos de la persona */
				$qry ="INSERT INTO tbl_personas 
				(pe_nombre, pe_tel, pe_cedula, pe_licencia, pe_licencia_vigencia, pe_dir, pe_cel, pe_tipo, pe_created, pe_estado, pe_f1, pe_f2, pe_ve_id) 
				VALUES 
				('".$nombre."', '".$tel."', '".$ced."', '".$lic."', '".$lic_v."', '".$dir."', '".$cel."', '".$tipo."', ".$_SESSION["ses_id"].", 1 , '".$f1."', '".$f2."', ".$placa.");";
				//echo "QUERY: ".$qry;
				$resp = mysql_query($qry);
				if(!$resp){
					$res=false;
					$mes=$msg->get_msg("e003");
				}else{
					$res=true;
					$mes=$msg->get_msg("e004");
				}	
			}else{
				$res=false;
				$mes=$msg->get_msg("e003-1", "El usuario ya existe");
			}


			
		}
		$response->res = $res;
		$response->mes = $mes;
		echo json_encode($response);

		$con->disconnect();

	}
	//NO BORRAR!!! sirve para traer las fincas de preferencia
	//consultamos lotes de la finca desde la matriz ica
	function get_fincas(){	
		$fun = new funciones();
		$msg = new messages();
		$response = new StdClass;

		/*recibimos variables*/
		$cod=$_POST["cod"];

		$con = new con();
		$con->connect();

		/* ingresamos datos de la finca */
		$item="";
		$qry_lotes ='SELECT * FROM tbl_ WHERE codfinca="'.$cod.'";';
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
          case 'save' : add_persona();break;
      }
  }
?>