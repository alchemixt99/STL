<?php
/*Control de mensajes de error en el sistema*/
class messages{
	function get_msg($e,$v=null){
		/* ====================== */
		$msg = [
			"e001" => "Welcome",
			"e002" => "Usuario o contraseña inválidos",
			"e003" => "Error al intentar almacenar el registro, por favor intentelo nuevamente.",
			"e003-1" => "Error: ".$v.".",
			"e004" => "Registrado con éxito.",
			"e004-1" => "Registrado con éxito.".$v,
			"e005" => "Campos Vacíos, verifique que los campos sean correctos e intentelo de nuevo.",
			"e006" => "El código de finca ingresado no coincide con el de la base de datos, favor verificar el código e intentar nuevamente.",
			"e007" => "El código de finca ingresado ya fué registrado, favor verificar el código e intentar nuevamente.",
			"e008" => "No hay lotes seleccionados para esta finca, comuniquese con gerencia para validar información.",
			"e009" => "Problemas Actualizando el volumen en la matriz de datos.",
			"e010" => "No hay Supervisores asignados a esta finca, comuniquese con gerencia para validar información.",
		];
		/* ====================== */
		return $msg[$e];
	}
	function console_log ($str){
		$js = '
		<script type="text/javascript">console.log("'.$str.'");</script>
		';
		return $js;
	}
}


?>