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

	function existe($tbl,$field,$var, $and=""){
		$con = new con();
		$con->connect();
		//preguntamos si existe la finca en la matriz entregada
		$selectSQL ="SELECT * FROM tbl_".$tbl." WHERE `$field` = '$var' ".$and.";";		
		//echo $selectSQL;
		$row_cons = mysql_query($selectSQL);
		if(mysql_num_rows($row_cons)>0){$respuesta=true;}else{$respuesta=false;}
		
		/*Termina Consulta*/
		return $respuesta;
	}
	function get_id($id,$tbl,$field,$var, $and=""){
		$con = new con();
		$con->connect();
		//traemos id
		$selectSQL ="SELECT ".$id." FROM tbl_".$tbl." WHERE `$field` = '$var' ".$and.";";
		//echo $selectSQL;
		$res_cons = mysql_query($selectSQL);
		while($row_cons = mysql_fetch_array($res_cons)){
			if($res_cons){
				$respuesta=$row_cons[0];
			}else{
				$respuesta=false;
			}
		}
		
		/*Termina Consulta*/
		return $respuesta;
	}
	function get_custom($qry, $and=""){
		$con = new con();
		$con->connect();
		//traemos consulta
		$selectSQL =$qry;
		//echo $selectSQL;
		$res_cons = mysql_query($selectSQL);
		while($row_cons = mysql_fetch_array($res_cons)){
			if($res_cons){
				$respuesta=$row_cons[0];
			}else{
				$respuesta=false;
			}
		}
		
		/*Termina Consulta*/
		return $respuesta;
	}
	function get_array($qry, $and=""){
		$con = new con();
		$con->connect();
		$respuesta = array();
		//traemos consulta
		$selectSQL =$qry;
		//echo $selectSQL;
		$res_cons = mysql_query($selectSQL);
		if($res_cons){
			while($row_cons = mysql_fetch_assoc($res_cons)){
				array_push($respuesta, $row_cons);
			}
		}else{
			$respuesta=false;
		}
		
		
		/*Termina Consulta*/
		return $respuesta;
	}
	function actualizar($tbl,$cambios,$where="1"){
		$con = new con();
		$con->connect();
		//preguntamos si existe la finca en la matriz entregada
		$selectSQL ="UPDATE tbl_".$tbl." SET ".$cambios." WHERE ".$where.";";
		//echo $selectSQL;
		$res_upd = mysql_query($selectSQL);
		if($res_upd){$respuesta=true;}else{$respuesta=false;}
		
		/*Termina Consulta*/
		return $respuesta;
	}
	function borrar($tbl,$field,$var,$and=""){
		$campos="";
		switch ($tbl) {
			case 'usuarios': $campos= "us_estado=99"; break;
			case 'fincas': $campos= "fi_estado=99"; break;
			case 'inventario': $campos= "in_estado=99"; break;
			case 'control_inventarios': $campos= "ci_estado=99"; break;
			case 'lotes_autorizados': $campos= "la_estado=99"; break;
			case 'supervisores': $campos= "su_estado=99"; break;
			case 'vehiculos': $campos= "ve_estado=99"; break;
			case 'remisiones_fisicas': $campos= "rf_estado=99"; break;
		}
		$con = new con();
		$con->connect();
		//preguntamos si existe la finca en la matriz entregada
		$selectSQL ="UPDATE tbl_".$tbl." SET ".$campos." WHERE ".$field." = '".$var."' ".$and.";";
		//echo $selectSQL;
		$res_del = mysql_query($selectSQL);
		if($res_del){$respuesta=true;}else{$respuesta=false;}
		
		/*Termina Consulta*/
		return $respuesta;
	}
	function activar($tbl,$field,$var,$and=""){
		$campos="";
		switch ($tbl) {
			case 'usuarios': $campos= "us_estado=1"; break;
			case 'fincas': $campos= "fi_estado=1"; break;
			case 'inventario': $campos= "in_estado=1"; break;
			case 'control_inventarios': $campos= "ci_estado=1"; break;
			case 'lotes_autorizados': $campos= "la_estado=1"; break;
			case 'remisiones_fisicas': $campos= "rf_estado=1"; break;
		}
		$con = new con();
		$con->connect();
		//preguntamos si existe la finca en la matriz entregada
		$selectSQL ="UPDATE tbl_".$tbl." SET ".$campos." WHERE ".$field." = '".$var."' ".$and.";";		
		$res_cons = mysql_query($selectSQL);
		if($res_cons){$respuesta=true;}else{$respuesta=false;}
		
		/*Termina Consulta*/
		return $respuesta;
	}
	function crear($tbl,$fields,$values){
		$con = new con();
		$con->connect();
		//preguntamos si existe la finca en la matriz entregada
		$selectSQL ="INSERT INTO tbl_".$tbl." (".$fields.") VALUES (".$values.");";
		//echo $selectSQL;
		$res_cons = mysql_query($selectSQL);
		if($res_cons){$respuesta=true;}else{$respuesta=false;}
		
		/*Termina Consulta*/
		return $respuesta;
	}
	function print_array($a){
		echo "<pre>";
		print_r($a);
		echo "<pre>";
	}

	function create_file($content, $filename){
		$ruta = "../informes/";
		$file=fopen($ruta.$filename,"a") or die("Problemas");
		fputs($file,$content);
		fclose($file);
	}

	function datepicker($id="",$f){
		//año
		$año ='	<select class="form-control valued" style="width:50px; float:left;" id="'.$id.'_y">';
			for ($i=(date("Y")+1); $i >= 2000; $i--) { 
				$año.='<option value="'.$i.'">'.$i.'</option>';
			}   
	    $año.=' </select>';
		//mes
		$meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
		$mes ='	<select class="form-control valued" style="width:95px; float:left;" id="'.$id.'_m">';
			for ($i=1; $i <= 12; $i++) { 
				$mes.='<option value="'.$i.'">'.$meses[($i-1)].'</option>';
			}   
	    $mes.=' </select>';
		//dia
		$dia ='	<select class="form-control valued" style="width:40px; float:left;" id="'.$id.'_d">';
			for ($i=1; $i <= 31; $i++) { 
				$dia.='<option value="'.$i.'">'.$i.'</option>';
			}   
	    $dia.=' </select>';

	    switch ($f) {
	    	case 'dmy':
	    		return $dia.' '.$mes.' '.$año;
	    	break;
	    }



		
	}
}
?>