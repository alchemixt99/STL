<?php
session_start();
require("funciones.php");
require("messages.php");

$fun = new funciones();
if(!$fun->isAjax()){header ("Location: ../../mods/panel/panel.php");}

  //=============Definimos funciones===================
	//agregar usuario
	function add_usuario(){	
		$fun = new funciones();
		$msg = new messages();
		$response = new StdClass;

		/*recibimos variables*/
		$placa=mysql_real_escape_string($_POST['placa']);
		$propi=mysql_real_escape_string($_POST['propi']);
		$capac=mysql_real_escape_string($_POST['capac']);

		/* Encriptamos clave */
		//$pass = sha1(md5($pass));


		if($placa=="" || $propi=="" || $capac==""){
			$res=false;
			$mes=$msg->get_msg("e005");
		}else
		{
			$con = new con();
			$con->connect();

			/* verificamos que exista la cuenta para evitar redundancias*/
			$res_us = $fun->existe("vehiculos","ve_placa",$placa);
			if(!$res_us){
				/* ingresamos datos del supervisor */
				$qry ="INSERT INTO tbl_vehiculos (ve_placa, ve_pe_id, ve_capacidad_m3, ve_created, ve_estado)
						VALUES ('".$placa."',".$propi.",".$capac.",".$_SESSION["ses_id"].",1);";
				//echo $qry;
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
				$mes=$msg->get_msg("e023");
			}
		}			
		
		$response->res = $res;
		$response->mes = $mes;
		echo json_encode($response);

		$con->disconnect();

	}
	//Borrar usuario
	function remove_user(){
		$fun = new funciones();
		$msg = new messages();
		$response = new StdClass;

		/*recibimos variables*/
		$user=$_POST["user"];
		$res=$fun->borrar("vehiculos","ve_id",$user);
		if ($res) {
			$res=true;
			$mes=$msg->get_msg("e004");
		}else{
			$res=false;
			$mes=$msg->get_msg("e022");
		}
		
		$response->res = $res;
		$response->mes = $mes;
		echo json_encode($response);
	}
  //validamos si es una petición ajax
  if(isset($_POST['action']) && !empty($_POST['action'])) {
      $action = $_POST['action'];
      switch($action) {
          case 'save' : add_usuario();break;
          case 'change_pass' : change_usuario();break;
          case 'del_user' : remove_user();break;
      }
  }
?>