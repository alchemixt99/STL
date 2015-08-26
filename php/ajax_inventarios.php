<?php
session_start();
require("funciones.php");
require("messages.php");

$fun = new funciones();
if(!$fun->isAjax()){header ("Location: ../../mods/panel/panel.php");}

  //=============Definimos funciones===================
	//agregar inventario
	function add_inventario(){	
		$msg = new messages();
		$response = new StdClass;

		/*recibimos variables*/
		$cod=$_POST["cod"];
		$sup=$_POST["sup"];
		$lote=$_POST["lote"];
		$inv=$_POST["inv"];
		$tipom=$_POST["tipom"];

		if($inv==""){
			$res=false;
			$mes=$msg->get_msg("e005");
		}else{
			$con = new con();
			$con->connect();
		

			/* ingresamos datos de la finca */
			$qry ="INSERT INTO tbl_inventario (in_fi_id, in_supervisor, in_lote, in_mt_cubico, in_tipo_materia, in_created, in_estado)
					VALUES (".$cod.",'".$sup."','".$lote."',".$inv.",".$tipom.",".$_SESSION["ses_id"].",1);";

			//echo "<br>Consulta: ".$qry;
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

	//traemos lotes autorizados
	function lotes_au(){
		//cargar lotes segun la finca que se seleccione, lotes de la tabla lotes_autorizados
		$msg = new messages();
		$response = new StdClass;

		/*recibimos variables*/
		$cod=$_POST["cod"];

		if($cod==""){
			$res=false;
			$mes=$msg->get_msg("e005");
		}else{
			$con = new con();
			$con->connect();
		
			/* Consultamos los lotes de la finca autorizados por gerencia con anterioridad */
			$qry ="SELECT DISTINCT L.la_id, F.fi_nombre, L.la_idlote, F.fi_codigo FROM tbl_lotes_autorizados AS L 
					INNER JOIN tbl_fincas AS F 
					INNER JOIN tbl_matriz_ica AS M 
					WHERE 
					F.fi_id = L.la_fi_id AND 
					M.idlote = L.la_idlote AND 
					L.la_fi_id = $cod
					ORDER BY L.la_idlote ASC;";

			$resp = mysql_query($qry);
			$cant=mysql_num_rows($resp);
			if($cant>0){
				$item='';
				while($row_resp = mysql_fetch_assoc($resp)){
					$item.='<option value="'.$row_resp["la_id"].'">'.$row_resp["la_idlote"].'</option>';
				}	

				$html='
			        <select class="form-control valued" id="lote">
			          '.$item.'
			        </select>
			        <label for="lote" class="">Lote</label>
			    ';
				$res=true;
				$mes=$html;


			}else{
				$res=false;
				$mes=$msg->get_msg("e008");
			}
		}
		$response->res = $res;
		$response->mes = $mes;
		echo json_encode($response);

		$con->disconnect();

	}

  //validamos si es una petición ajax
  if(isset($_POST['action']) && !empty($_POST['action'])) {
      $action = $_POST['action'];
      switch($action) {
          case 'save' : add_inventario();break;
          case 'get_lotes' : lotes_au();break;
      }
  }
?>