<?php
session_start();
class route{
	/*====== Rutas ===========*/
	function path($e){
		$rt = [
			"login"=>"../login/login.php",
			"panel"=>"../panel/panel.php"
		];
		return $rt[$e];
	}
	/*====== Redireccionar ===========*/
	function routing($p){
		header('location: '.$p);
	}

	function check_session(){
		if(isset($_SESSION["ses_id"]))
		{
			$s_id=$_SESSION["ses_id"];
			$s_tipo=$_SESSION["ses_tipo"];
			//$this->routing($this->path("panel"));
		}
		else{
			$this->routing($this->path("login"));
		}
	}
}
?>