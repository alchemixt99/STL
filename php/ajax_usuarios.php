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
		$nomb=mysql_real_escape_string($_POST['nomb']);
		$iden=mysql_real_escape_string($_POST['iden']);
		$user=mysql_real_escape_string($_POST['user']);
		$tipo=mysql_real_escape_string($_POST['tipo']);
		$pass=$_POST['pass'];

		/* Encriptamos clave */
		//$pass = sha1(md5($pass));


		if($nomb=="" || $tipo=="" || $pass==""){
			$res=false;
			$mes=$msg->get_msg("e005");
		}else
		{
			$con = new con();
			$con->connect();

			/* verificamos que exista la cuenta para evitar redundancias*/
			$res_us = $fun->existe("usuarios","us_usuario",$user);

				if(!$res_us){
					/* ingresamos datos del usuario */
					$qry ="INSERT INTO tbl_usuarios (us_nombre, us_cc, us_tipo, us_usuario, us_clave, us_created, us_estado)
							VALUES ('".$nomb."','".$iden."','".$tipo."', '".$user."', '".$pass."',".$_SESSION["ses_id"].",1);";
					$resp = mysql_query($qry);
					if(!$resp){
						$res=false;
						$mes=$msg->get_msg("e003");
					}else{
						//Si la insercción fué correcta, traemos el id del usuario y lo asociaremos al tipo de usuario que se autorizó
						$qry_ti="SELECT us_id, us_tipo FROM tbl_usuarios WHERE us_cc='".$iden."' ORDER BY us_timestamp DESC LIMIT 1;";
						$res_ti=mysql_query($qry_ti);
						if($row_ti=mysql_fetch_assoc($res_ti)){
							//Asignamos Permisos
							$qry_pe='INSERT INTO tbl_per_x_usu (pxu_us_id, pxu_pe_id, pxu_created, pxu_estado) 
							VALUES('.$row_ti['us_id'].', '.$row_ti['us_tipo'].', '.$_SESSION["ses_id"].', 1);';
							$res_pe=mysql_query($qry_pe);
							if (!$res_pe) {
								$res=false;
								$mes=$msg->get_msg("e012");
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
					$mes=$msg->get_msg("e011");
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
	//Cambiar contraseña
	function change_usuario($opt=null){	
		$fun = new funciones();
		$msg = new messages();
		$response = new StdClass;

		/*recibimos variables*/
		$user=$_POST["user"];
		$pass=$_POST["ch_pass"];
		//Encriptamos clave
		$pass = sha1(md5($pass));

		$con = new con();
		$con->connect();

		$qry='UPDATE tbl_usuarios 
				SET us_clave="'.$pass.'" WHERE us_id='.$user.';';
		$res=mysql_query($qry);
		if ($res) {
			$res=true;
			$mes=$msg->get_msg("e004");
		}else{
			$res=false;
			$mes=$msg->get_msg("e013");
		}
				
		$con->disconnect();
		
		$response->res = $res;
		$response->mes = $mes;
		echo json_encode($response);
	}
	//Borrar usuario
	function remove_user(){
		$fun = new funciones();
		$msg = new messages();
		$response = new StdClass;

		/*recibimos variables*/
		$user=$_POST["user"];
		$res=$fun->borrar("usuarios","us_id",$user);
		if ($res) {
			$res=true;
			$mes=$msg->get_msg("e004");
		}else{
			$res=false;
			$mes=$msg->get_msg("e014");
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