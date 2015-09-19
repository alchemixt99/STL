<?php
include_once("db.php");

class funciones{
	/* Función para Enviar Email*/
	function enviar_email($para, $titulo, $mensaje) {
		$cabeceras = 'Content-type: text/html; charset=UTF-8'. "\r\n" .
		'From: $correo' . "\r\n" .
		'Reply-To: $correo' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();
		return mail($para, $titulo, $mensaje, $cabeceras);
	}

	/*Funcion validar datos*/
	function validar($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")   
	{  
	  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;  
	  switch ($theType) {  
	   	case "text":  
	      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";  
		break;      
	    case "long":  
		case "int":  
		  $theValue = ($theValue != "") ? intval($theValue) : "NULL";  
		break;  
	    case "double":  
	      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";  
		break;  
	    case "date":  
		  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";  
	    break;  
		case "defined":  
	      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;  
		break;  
	 }  
	 return $theValue;  
	}

	function isAjax()
	{
	    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
	    {return true;}
	    else
	    {return false;}
	}	

	function existe($tbl,$field,$var){
		$con = new con();
		$con->connect();
		//preguntamos si existe la finca en la matriz entregada
		$selectSQL ="SELECT * FROM tbl_".$tbl." WHERE `$field` = '$var'";
		$row_cons = mysql_query($selectSQL);
		if(mysql_num_rows($row_cons)>0){$respuesta=true;}else{$respuesta=false;}
		
		/*Termina Consulta*/
		return $respuesta;
	}
	function borrar($tbl,$field,$var){
		$campos="";
		switch ($tbl) {
			case 'usuarios': $campos= "us_estado=99"; break;
			case 'fincas': $campos= "fi_estado=99"; break;
			case 'inventario': $campos= "in_estado=99"; break;
			case 'control_inventarios': $campos= "ci_estado=99"; break;
			case 'lotes_autorizados': $campos= "la_estado=99"; break;
		}
		$con = new con();
		$con->connect();
		//preguntamos si existe la finca en la matriz entregada
		$selectSQL ="UPDATE tbl_".$tbl." SET ".$campos." WHERE ".$field." = '".$var."';";
		$res_cons = mysql_query($selectSQL);
		if($res_cons){$respuesta=true;}else{$respuesta=false;}
		
		/*Termina Consulta*/
		return $respuesta;
	}
	function crear($tbl,$fields,$vars){
		$campos="";
		switch ($tbl) {
			case 'usuarios': $campos= "us_estado=99"; break;
			case 'fincas': $campos= "fi_estado=99"; break;
			case 'inventario': $campos= "in_estado=99"; break;
			case 'control_inventarios': $campos= "ci_estado=99"; break;
			case 'lotes_autorizados': $campos= "la_estado=99"; break;
		}
		$con = new con();
		$con->connect();
		//preguntamos si existe la finca en la matriz entregada
		$selectSQL ="UPDATE tbl_".$tbl." SET ".$campos." WHERE ".$field." = '".$var."';";
		$res_cons = mysql_query($selectSQL);
		if($res_cons){$respuesta=true;}else{$respuesta=false;}
		
		/*Termina Consulta*/
		return $respuesta;
	}
}
?>