<?php
class con {  
	//variables de conexion  
    private $host = 'localhost';  
    private $user = 'root';  
    private $pass = '';  
    public $type = 'mysql';  
    private $db = "stl_logistik";   
    public $lid = 0;  

    //funcion de conexion  
    function connect() {  
        $connect = $this->type.'_connect';  
              
        if (!$this->lid = $connect($this->host, $this->user, $this->pass)) {  
              
        }  
		else {  
			$sql = $this->type.'_select_db';			   
			if (!$baseconections = $sql($this->db,$this->lid)) {  
				mysql_query("SET NAMES 'utf8'");  
			}  
		}  
		  
		return ($this->lid);  
 	}//termina conexion  

	//funcion de desconexion  
	function disconnect()  
	{  
	 	$desconnect = $this->type.'_close';  
		$desconnect($this->lid);  
	}//termina funcion de desconexion  	  
}  
?>