<?php
session_start();
require("funciones.php");
require("messages.php");

$fun = new funciones();
if(!$fun->isAjax()){header ("Location: ../../mods/panel/panel.php");}

  //=============Definimos funciones===================
	//agregar fincas
	function add_persona(){	
		$fun = new funciones();
		$msg = new messages();
		$response = new StdClass;

		/*recibimos variables*/
		$tipo = $_POST['tipo'];
		$nombre = $_POST['nombre'];
		$ced = $_POST['ced'];
		$lic = $_POST['lic'];
		$lic_v = $_POST['lic_v'];
		$dir = $_POST['dir'];
		$tel = $_POST['tel'];
		$cel = $_POST['cel'];
		$f1 = $_POST['f1'];
		$f2 = $_POST['f2'];
		$placa = $_POST['placa'];

		if($tipo==1){$placa="0";}

		if($nombre==""){
			$res=false;
			$mes=$msg->get_msg("e005");
		}else
		{
			$con = new con();
			$con->connect();

			/* verificamos que no esté registrado en la tabla de personas*/
			$res_existe = $fun->existe("personas","pe_cedula",$ced);
			if(!$res_existe){
				/* ingresamos datos de la persona */
				$qry ="INSERT INTO tbl_personas 
				(pe_nombre, pe_tel, pe_cedula, pe_licencia, pe_licencia_vigencia, pe_dir, pe_cel, pe_tipo, pe_created, pe_estado, pe_f1, pe_f2, pe_ve_id) 
				VALUES 
				('".$nombre."', '".$tel."', '".$ced."', '".$lic."', '".$lic_v."', '".$dir."', '".$cel."', '".$tipo."', ".$_SESSION["ses_id"].", 1 , '".$f1."', '".$f2."', ".$placa.");";
				//echo "QUERY: ".$qry;
				$resp = mysql_query($qry);
				if(!$resp){
					$res=false;
					$mes=$msg->get_msg("e003");
				}else{
					$res=true;
					$mes=$msg->get_msg("e004");
				}	
			}else{
				$res=false;
				$mes=$msg->get_msg("e003-1", "El usuario ya existe");
			}


			
		}
		$response->res = $res;
		$response->mes = $mes;
		echo json_encode($response);

		$con->disconnect();

	}
	//traemos datos para las gráficas
	function get_data($opc){	
		$fun = new funciones();
		$msg = new messages();
		$response = new StdClass;

		$con = new con();
		$con->connect();

		switch ($opc) {
			case 1:
				$item ="";
				$arr=array();
				$year = date("Y");
				for ($i=1; $i <= 12 ; $i++) { 
					$qry_gr ="SELECT COUNT(de_id) AS conteo FROM `tbl_despachos` WHERE de_timestamp BETWEEN '".$year."-".$i."-01 00:00:00' AND '".$year."-".$i."-31 23:59:59'";
					$res_gr = mysql_query($qry_gr);
					while($row_gr = mysql_fetch_assoc($res_gr)) {
						$arr[]=array(
							'month' => $year."-".$i,
							'value' => $row_gr['conteo']
							);
					}
				}
			break;
			case 2:
				$item ="";
				$arr=array();

				$qry_gr ="SELECT COUNT(fi_id) AS conteo FROM `tbl_fincas` WHERE fi_estado=1";
				$res_gr = mysql_query($qry_gr);
				while($row_gr = mysql_fetch_assoc($res_gr)) {
					$arr[]=array(
						'label' => "Fincas Autorizadas",
						'value' => $row_gr['conteo']
						);
				}

				$qry_gr ="SELECT COUNT(DISTINCT(codfinca)) AS conteo FROM `tbl_matriz_ica`";
				$res_gr = mysql_query($qry_gr);
				while($row_gr = mysql_fetch_assoc($res_gr)) {
					$arr[]=array(
						'label' => "Fincas Existentes",
						'value' => $row_gr['conteo']
						);
				}
			break;

			case 3:
				$item ="";
				$arr=array();
				$year = date("Y");
				
				$qry_gr ="SELECT * FROM tbl_inventario";
				$res_gr = mysql_query($qry_gr);
				while($row_gr = mysql_fetch_assoc($res_gr)) {
					$arr[]=array(
						'id' => $row_gr['in_id'],
						'vol' => $row_gr['in_mt_restante'],
						);
				}
				
			break;
		}
		
		$res=true;
		$mes=$arr;
				
		
		$response->res = $res;
		$response->mes = $mes;
		echo json_encode($response);

		$con->disconnect();

	}

  //validamos si es una petición ajax
  if(isset($_POST['action']) && !empty($_POST['action'])) {
      $action = $_POST['action'];
      switch($action) {
          case 'get_001' : get_data(1);break;
          case 'get_002' : get_data(2);break;
          case 'get_003' : get_data(3);break;
      }
  }
?>