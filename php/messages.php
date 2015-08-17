<?php
/*Control de mensajes de error en el sistema*/
class messages{
	function get_msg($e){
		/* ====================== */
		$msg = [
			"e001" => "Welcome",
			"e002" => "Usuario o contraseña inválidos",
			"e003" => "Error al intentar almacenar el registro, por favor intentelo nuevamente.",
			"e004" => "Registrado con éxito.",
			"e005" => "Campos Vacíos, verifique que los campos sean correctos e intentelo de nuevo.",
		];
		/* ====================== */
		return $msg[$e];
	}
}


?>