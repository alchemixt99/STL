<?php
class jslib{
	function get_js(){
		$js = '
			<script type="text/javascript" src="../../lib/js/funciones.js"></script>
		';
		return $js;
	}
	function get_css(){
		$css = '
			<link rel="stylesheet" href="../../lib/bootstrap.css" type="text/css">
			<link rel="stylesheet" href="../../lib/font.css" type="text/css">
			<link rel="stylesheet" href="../../lib/materia.css" type="text/css">
		';
		return $css;
	}
}
?>