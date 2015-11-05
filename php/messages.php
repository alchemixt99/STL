<?php
/*Control de mensajes de error en el sistema*/
class messages{
	function get_msg($e,$v=null){
		/* ====================== */
		$msg = [
			"e001" => "001 - Welcome",
			"e002" => "002 - Usuario o contraseña inválidos",
			"e003" => "003 - Error al intentar almacenar el registro, por favor intentelo nuevamente.",
			"e003-1" => "003.1 - Error: ".$v.".",
			"e004" => "004 - Registrado con éxito.",
			"e004-1" => "004.1 - Registrado con éxito.".$v,
			"e005" => "005 - Campos Vacíos, verifique que los campos sean correctos e intentelo de nuevo.",
			"e006" => "006 - El código de finca ingresado no coincide con el de la base de datos, favor verificar el código e intentar nuevamente.",
			"e007" => "007 - El código de finca ingresado ya fué registrado, favor verificar el código e intentar nuevamente.",
			"e008" => "008 - No hay lotes seleccionados para esta finca, comuniquese con gerencia para validar información.",
			"e009" => "009 - Problemas Actualizando el volumen en la matriz de datos.",
			"e010" => "010 - No hay Supervisores asignados a esta finca, comuniquese con gerencia para validar información.",
			"e011" => "011 - Este usuario ya está registrado en el sistema.",
			"e012" => "012 - Ocurrió un error al asignar permisos, comuniquese con soporte, gracias.",
			"e013" => "013 - Ocurrió un error al cambiar la contraseña, comuniquese con soporte, gracias.",
			"e014" => "014 - Este usuario no se puede eliminar, comuniquese con soporte, gracias.",
			"e015" => "015 - Esta finca no se puede eliminar, comuniquese con soporte, gracias.",
			"e016" => "016 - Problemas al borrar los lotes autorizados, comuniquese con soporte, gracias.",
			"e017" => "017 - Problemas al borrar el control de inventarios, comuniquese con soporte, gracias.",
			"e018" => "018 - Problemas al borrar inventarios asociados, comuniquese con soporte, gracias.",
			"e019" => "019 - Problemas al borrar inventario, comuniquese con soporte, gracias.",
			"e020" => "020 - Este supervisor no se puede eliminar, comuniquese con soporte, gracias.",
			"e021" => "021 - Este supervisor ya está registrado en el sistema.",
			"e022" => "022 - Este vehiculo no se puede eliminar, comuniquese con soporte, gracias.",
			"e023" => "023 - Este Vehiculos ya está registrado en el sistema.",
			"e024" => "024 - Problemas al vincular conductores, comuniquese con soporte, gracias.",
			"e025" => "025 - Error al intentar obtener subnucleos.",
			"e026" => "026 - Error al intentar realizar la consulta.",
			"e027" => "027 - Error al intentar autorizar el despacho, comuniquese con soporte, gracias.",
			"e028" => "028 - No existe el despacho que está buscando, comuniquese con soporte, gracias.",
			"e029" => "029 - Este supervisor no está registrado en el sistema.",
			"e030" => "030 - Error al cargar datos del inventario.",
			"e031" => "031 - Error al desactivar el conductor, comuniquese con soporte, gracias.",
			"e032" => "032 - Error al activar el conductor, comuniquese con soporte, gracias.",
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