<?php
session_start();
class route{
	function enrute($e){
		$rt = [
			"login"=>"",
			"panel"=>""
		];
		return $rt[$e];
	}
}
?>