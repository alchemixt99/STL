<?php
session_start();
require("funciones.php");
require("messages.php");

$fun = new funciones();
if(!$fun->isAjax()){header ("Location: ../../mods/panel/panel.php");}

  //=============Definimos funciones===================
	//agregar fincas
	function add_finca(){	
		$msg = new messages();
		$response = new StdClass;

		/*recibimos variables*/
		$cod=$_POST["cod"];

		if($nombre==""){
			$res=false;
			$mes=$msg->get_msg("e005");
		}else{
			$con = new con();
			$con->connect();
		

			/* ingresamos datos de la finca */
			$qry ="INSERT INTO tbl_fincas (fi_codigo, fi_nombre, fi_supervisor, fi_ciudad, fi_dir, fi_tel, fi_created, fi_estado)
					VALUES ('".$cod."','".$nombre."','".$supervisor."','".$ciudad."','".$dir."','".$tel."',".$_SESSION["ses_id"].",1);";

			$resp = mysql_query($qry);
			if(!$resp){
				$res=false;
				$mes=$msg->get_msg("e003");
			}else{
				$res=true;
				$mes=$msg->get_msg("e004");
			}
		}
		$response->res = $res;
		$response->mes = $mes;
		echo json_encode($response);

		$con->disconnect();

	}

	//traemos lotes autorizados
	function lotes_au(){
		//cargar lotes segun la finca que se seleccione, lotes de la tabla lotes_autorizados
	}

  //validamos si es una petición ajax
  if(isset($_POST['action']) && !empty($_POST['action'])) {
      $action = $_POST['action'];
      switch($action) {
          case 'save' : add_finca();break;
          case 'get_lotes' : add_finca();break;
      }
  }
?>