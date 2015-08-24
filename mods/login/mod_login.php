<?php 
session_start();

require("../../php/funciones.php");
require("../../php/messages.php");

$msg = new messages();

$fun = new funciones();
if(!$fun->isAjax()){header ("Location: login.php");}

$con = new con();
$con->connect();

$response = new StdClass;

$usu = $_POST['user'];
$pass = $_POST['pass'];
//$pass = sha1(md5($pass));



/* $pass_encriptada1 = md5 ($pass); //Encriptacion nivel 1
$pass_encriptada2 = crc32($pass_encriptada1); //Encriptacion nivel 1
$pass_encriptada3 = sha1("xtemp".$pass_encriptada2); //Encriptacion nivel 3
$pass_encriptada4 = crypt($pass_encriptada3, "xtemp"); //Encriptacion nivel 2 */

/*Consulta a la Bd*/
$selectSQL ="SELECT * FROM `tbl_usuarios` WHERE `us_usuario` = '$usu' AND `us_clave` = '$pass'";

$row_cons = mysql_query($selectSQL);
$existe = mysql_fetch_assoc($row_cons);
/*Termina Consulta*/

/*Existe*/
//$existe = 1;
if($existe){
	$res = true;
	$mes = $msg->get_msg("e001");
	
	$_SESSION["ses_id"] = $existe['us_id'];
	$_SESSION["ses_tipo"] = $existe['us_tipo'];
	
	//$menu = 1;
}else{
	$res = false;
	$mes = $msg->get_msg("e002");
}

$response->res = $res;
$response->mes = $mes;
echo json_encode($response);

$con->disconnect();
?>