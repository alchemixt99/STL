<?php
/*Control de mensajes de error en el sistema*/
class messages{
	function get_msg($e){
		/* ====================== */
		$msg = [
			"e001" => "Welcome",
			"e002" => "Usuario o contraseña inválidos",
		];
		/* ====================== */
		return $msg[$e];
	}
}


?>