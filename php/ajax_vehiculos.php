<?php
session_start();
require("funciones.php");
require("messages.php");

$fun = new funciones();
if(!$fun->isAjax()){header ("Location: ../../mods/panel/panel.php");}

  //=============Definimos funciones===================
	//agregar vehiculo
	function add_vehiculo(){	
		$fun = new funciones();
		$msg = new messages();
		$response = new StdClass;
		$con = new con();
		$con->connect();
		

		/*recibimos variables*/
		$tipo = mysql_real_escape_string($_POST['tipo']);
		$marca = mysql_real_escape_string($_POST['marca']);
		$modelo = mysql_real_escape_string($_POST['modelo']);
		$color = mysql_real_escape_string($_POST['color']);
		$linea = mysql_real_escape_string($_POST['linea']);
		$placa = mysql_real_escape_string($_POST['placa']);
		$nro_motor = mysql_real_escape_string($_POST['nro_motor']);
		$nro_chasis = mysql_real_escape_string($_POST['nro_chasis']);
		$cod_prop = mysql_real_escape_string($_POST['cod_prop']);
		$empresa = mysql_real_escape_string($_POST['emp']);
		$emp_soat = mysql_real_escape_string($_POST['emp_soat']);
		$num_soat = mysql_real_escape_string($_POST['num_soat']);
		$ven_soat = mysql_real_escape_string($_POST['ven_soat']);
		$emp_rt = mysql_real_escape_string($_POST['emp_rt']);
		$num_rt = mysql_real_escape_string($_POST['num_rt']);
		$ven_rt = mysql_real_escape_string($_POST['ven_rt']);
		$tipo_rem = mysql_real_escape_string($_POST['tipo_rem']);
		$color_rem = mysql_real_escape_string($_POST['color_rem']);
		$marca_rem = mysql_real_escape_string($_POST['marca_rem']);
		$capacidad = str_replace(",", ".", $_POST['capacidad']);
		$tipo_llanta_dir = mysql_real_escape_string($_POST['tipo_llanta_dir']);
		$tipo_llanta_tra = mysql_real_escape_string($_POST['tipo_llanta_tra']);
		$tarjeta_operacion = mysql_real_escape_string($_POST['t_oper']);

		/* Encriptamos clave */
		//$pass = sha1(md5($pass));


		if($placa=="" || $cod_prop=="" || $capacidad==""){
			$res=false;
			$mes=$msg->get_msg("e005");
		}else
		{
			/* verificamos que exista la cuenta para evitar redundancias*/
			$res_us = $fun->existe("vehiculos","ve_placa",$placa);
			if(!$res_us){
				/* ingresamos datos del vehiculo */
				$qry ="INSERT INTO tbl_vehiculos (ve_empresa, ve_pe_id, ve_tipo_vehiculo, ve_modelo, ve_marca, ve_color, ve_nro_motor, ve_nro_chasis, ve_soat, ve_soat_nro,ve_soat_vence, ve_tecno, ve_tecno_vence, ve_placa, ve_remolque_tipo, ve_remolque_color, ve_remolque_marca, ve_capacidad_m3, ve_tipo_llanta_traccion, ve_tipo_llanta_direccional, ve_linea, ve_t_op, ve_created, ve_estado) 
										  VALUES ('".$empresa."', ".$cod_prop.", '".$tipo."', '".$modelo."', '".$marca."', '".$color."', '".$nro_motor."', '".$nro_chasis."', '".$emp_soat."', '".$num_soat."', '".$ven_soat."', '".$emp_rt."', '".$ven_rt."', '".$placa."', '".$tipo_rem."', '".$color_rem."','".$marca_rem."', '".$capacidad."', '".$tipo_llanta_tra."', '".$tipo_llanta_dir."', '".$linea."', '".$tarjeta_operacion."', '".$_SESSION["ses_id"]."',1);";
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
          case 'save' : add_vehiculo();break;
          case 'change_pass' : change_usuario();break;
          case 'del_user' : remove_user();break;
      }
  }
?>