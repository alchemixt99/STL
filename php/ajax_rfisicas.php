<?php
session_start();
require("funciones.php");
require("messages.php");

$fun = new funciones();
if(!$fun->isAjax()){header ("Location: ../../mods/panel/panel.php");}

  //=============Definimos funciones===================
	//agregar remisiones
	function add_pack(){	
		$msg = new messages();
		$response = new StdClass;

		/*recibimos variables*/
		$ini=$_POST["ini"];
		$fin=$_POST["fin"];
		$inter=$_POST["inter"];
		$per=$_POST["per"];

		if($ini=="" || $fin == "" || $inter == ""){
			$res=false;
			$mes=$msg->get_msg("e005");
		}else{
			$con = new con();
			$con->connect();

			/* ingresamos datos de la finca */
			$qry ="INSERT INTO tbl_remisiones_fisicas (rf_persona_entrega, rf_interventor, rf_dig_ini, rf_dig_fin, rf_created, rf_estado)
					VALUES ('".$per."','".$inter."',".$ini.",".$fin.",".$_SESSION["ses_id"].",1);";

			$resp = mysql_query($qry);
			if(!$resp){
				$res=false;
				$mes=$msg->get_msg("e003");
			}else{
				$res=true;
				$mes=$msg->get_msg("e004");
			}
		}
		$response->res = $res;
		$response->mes = $mes;
		echo json_encode($response);

		$con->disconnect();

	}

	//editar remisiones
	function edit_row(){	
		$msg = new messages();
		$response = new StdClass;
		$fun = new funciones();

		/*recibimos variables*/
		$key=$_POST["key"];
		$ini=$_POST["ini"];
		$fin=$_POST["fin"];
		$inter=$_POST["inter"];
		$per=$_POST["per"];

		if($ini=="" || $fin == "" || $inter == ""){
			$res=false;
			$mes=$msg->get_msg("e005");
		}else{
			$con = new con();
			$con->connect();

			/* ingresamos datos */
			$t='remisiones_fisicas';
			$c="rf_persona_entrega='".$per."', rf_interventor='".$inter."', rf_dig_ini=".$ini.", rf_dig_fin=".$fin;
			$w="rf_id=".$key;

			$resp = $fun->actualizar($t,$c,$w);
			
			if(!$resp){
				$res=false;
				$mes=$msg->get_msg("e003");
			}else{
				$res=true;
				$mes=$msg->get_msg("e004");
			}
		}
		$response->res = $res;
		$response->mes = $mes;
		echo json_encode($response);

		$con->disconnect();

	}

	function change_pack(){
		$fun = new funciones();
		$msg = new messages();
		$response = new StdClass;

		/*recibimos variables*/
		$act=$_POST["a"];
		$id=$_POST["id"];

		if($act=="" || $id == ""){
			$res=false;
			$mes=$msg->get_msg("e005");
		}else{
			$con = new con();
			$con->connect();

			if ($act==1) {
				//activar, cambiar a 99
				if($fun->borrar("remisiones_fisicas", "rf_id", $id)){
					$res=true;
					$mes=$msg->get_msg("e004");
				}else{
					$res=false;
					$mes=$msg->get_msg("e003-1", "Activando remision.");
				}
			}else{
				//desactivar, cambiar a 1
				if($fun->activar("remisiones_fisicas", "rf_id", $id)){
					$res=true;
					$mes=$msg->get_msg("e004");
				}else{
					$res=false;
					$mes=$msg->get_msg("e003-1", "Desactivando remision.");
				}
			}

		}
		$response->res = $res;
		$response->mes = $mes;
		echo json_encode($response);

		$con->disconnect();
	}

	function load_row(){
		$fun = new funciones();
		$msg = new messages();
		$response = new StdClass;

		/*recibimos variables*/
		$id=$_POST["id"];

		if($id == ""){
			$res=false;
			$mes=$msg->get_msg("e005");
		}else{
			$con = new con();
			$con->connect();

			//traemos datos según sea el id
			$qry = "SELECT * FROM `tbl_remisiones_fisicas` WHERE rf_id =".$id.";";
			$data = $fun->get_array($qry);
			if($data!=false){
				$res=true;
				$response->key = $data[0]['rf_id'];
				$response->ini = $data[0]['rf_dig_ini'];
				$response->fin = $data[0]['rf_dig_fin'];
				$response->inter = $data[0]['rf_interventor'];
				$response->persona = $data[0]['rf_persona_entrega'];
			}else{
				$res=false;
				$response->mes = $msg->get_msg("e034");
			}
		}
		$response->res = $res;
		echo json_encode($response);

		$con->disconnect();
	}

  //validamos si es una petición ajax
  if(isset($_POST['action']) && !empty($_POST['action'])) {
      $action = $_POST['action'];
      switch($action) {
          case 'save' : add_pack();break;
          case 'change' : change_pack();break;
          case 'get_row' : load_row();break;
          case 'update' : edit_row();break;
      }
  }
?>