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

		if($inv=="" || $cod==""){
			$res=false;
			$mes=$msg->get_msg("e005");
		}else{
			$con = new con();
			$con->connect();
		
			/* ingresamos datos del inventario */
			$qry ="INSERT INTO tbl_inventario (in_fi_id, in_supervisor, in_lote, in_mt_cubico, in_tipo_materia, in_created, in_estado)
					VALUES (".$cod.",'".$sup."','".$lote."',".$inv.",".$tipom.",".$_SESSION["ses_id"].",1);";
			$resp = mysql_query($qry);
			if(upd_matriz()){
				//cargamos variable de sesion con nuevo porcentaje
				$vol_p = $_SESSION["vol_perc"];
					switch ($vol_p) {
						case ($vol_p>=30):
							 $msg_por = '&nbsp;&nbsp;&nbsp;<span class="label label-success">AVISO: Capacidad actual del lote: '.$vol_p.'%</span>';
							break;
						case ($vol_p<=30 && $vol_p>16):
							 $msg_por = '&nbsp;&nbsp;&nbsp;<span class="label label-warning">ADVERTENCIA: Capacidad actual del lote: '.$vol_p.'%</span>';
							break;
						case ($vol_p<=15):
							 $msg_por = '&nbsp;&nbsp;&nbsp;<span class="label label-danger">PELIGRO: ¡ Capacidad actual del lote: '.$vol_p.'% !</span>';
							break;
						case ($vol_p<=0):
							 $msg_por = '&nbsp;&nbsp;&nbsp;<span class="label label-danger">Inventario Agotado - '.$vol_p.'%</span>';
							break;
						
						default:
							 $msg_por = "";
							break;
					}
				if(!$resp){
					$res=false;
					$mes=$msg->get_msg("e003");
				}else{
					$res=true;
					$mes=$msg->get_msg("e004-1", $msg_por);
				}
			}else{
				$res=false;
				$mes=$msg->get_msg("e009");
			}
		}
		$response->res = $res;
		$response->mes = $mes;
		echo json_encode($response);

		$con->disconnect();

	}
	//Actualizamos inventario de la matriz
	function upd_matriz(){
		$msg = new messages();
		$response = new StdClass;

		//traemos datos del inventario
		$qry_inv = "SELECT * FROM tbl_inventario ORDER BY in_id DESC LIMIT 1";
		$res_inv = mysql_query($qry_inv);
		$can_inv = mysql_num_rows($res_inv);
		$row_inv = mysql_fetch_assoc($res_inv);

		//traemos datos asociados a la finca y al lote desde la matriz ica
		$qry_fxm = "SELECT I.in_fi_id, M.codfinca, F.fi_nombre, L.la_idlote, I.in_lote , M.vol_ica_m3 FROM tbl_inventario AS I
					INNER JOIN tbl_fincas AS F ON F.fi_id = I.in_fi_id
					INNER JOIN tbl_lotes_autorizados AS L ON L.la_fi_id = F.fi_id
					INNER JOIN tbl_matriz_ica AS M ON M.idlote = L.la_idlote
					WHERE
					F.fi_codigo = M.codfinca AND
					F.fi_id = ".$row_inv['in_fi_id']." AND 
					L.la_id = ".$row_inv['in_lote'].";";
		$res_fxm = mysql_query($qry_fxm);
		$can_fxm = mysql_num_rows($res_fxm);
		$row_fxm = mysql_fetch_assoc($res_fxm);

		//traemos datos del control de inventarios
		$qry_lot = "SELECT * FROM tbl_control_inventarios WHERE ci_in_lote = ".$row_inv['in_lote'].";";
		//echo "<br>LOTES: ".$qry_lot;
		$res_lot = mysql_query($qry_lot);
		$can_lot = mysql_num_rows($res_lot);

		//echo "<br>cantidad de lotes: ".$can_lot;

		//verificamos si es la primera vez que se registra un cambio en ese lote
		if($can_lot==0){
			//si es primera vez, creamos el registro
			$nv = $row_fxm['vol_ica_m3']-$row_inv['in_mt_cubico'];
			$qry_new = "INSERT INTO tbl_control_inventarios (ci_fi_id, ci_in_lote, ci_vol_ini, ci_vol_act, ci_created, ci_estado)
					VALUES(".$row_fxm['in_fi_id'].",".$row_fxm['in_lote'].",".$row_fxm['vol_ica_m3'].",".$nv.",".$_SESSION["ses_id"].",1);";
		    $res_new= mysql_query($qry_new);

		    $vol_perc=(($nv/$row_fxm['vol_ica_m3']) * 100);
		    $_SESSION["vol_perc"]=$vol_perc;

		    if(!$res_new){$res=false;}else{$res=true;}
		}else{
			//de lo contrario, actualizamos el registro existente
			//traemos vol actual de ese lote de esa finca
			$qry_get = "SELECT * FROM tbl_control_inventarios WHERE ci_fi_id=".$row_fxm['in_fi_id']." AND ci_in_lote=".$row_fxm['in_lote'].";";
			//echo "<br>GET: ".$qry_get;
			$res_get = mysql_query($qry_get);
			$can_get = mysql_num_rows($res_get);
			$row_get = mysql_fetch_assoc($res_get);

			//calculamos nuevo volumen
			$vol_act_nuevo = $row_get['ci_vol_act'] - $row_inv['in_mt_cubico'];

			//Obtenemos porcentaje
			$vol_perc = (($vol_act_nuevo/$row_get['ci_vol_ini']) * 100);
			$_SESSION["vol_perc"]=$vol_perc;

			//actualizamos datos
			$qry_upd = "UPDATE tbl_control_inventarios SET
						ci_vol_act=".$vol_act_nuevo."
						WHERE ci_id=".$row_get['ci_id'].";";
			//echo "<br> UPD: ".$qry_upd;
		    $res_upd= mysql_query($qry_upd);
		    if(!$res_upd){$res=false;}else{$res=true;}			
		}
		//retornamos response
		return $res;
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
			$qry ="SELECT DISTINCT L.la_id, F.fi_nombre, L.la_idlote, F.fi_codigo, M.especie_ica, M.ano_plant FROM tbl_lotes_autorizados AS L 
					INNER JOIN tbl_fincas AS F 
					INNER JOIN tbl_matriz_ica AS M 
					WHERE 
					F.fi_id = L.la_fi_id AND 
					F.fi_codigo = M.codfinca AND
					M.idlote = L.la_idlote AND 
					L.la_fi_id = $cod
					ORDER BY L.la_idlote ASC;";

			$resp = mysql_query($qry);
			$cant=mysql_num_rows($resp);
			if($cant>0){
				$item='';
				while($row_resp = mysql_fetch_assoc($resp)){
					$item.='<option value="'.$row_resp["la_id"].'">'.$row_resp["la_idlote"].' - '.$row_resp["especie_ica"].' ('.$row_resp["ano_plant"].')</option>';
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
	//traemos Supervisores
	function supervisores(){
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
		
			/* Consultamos los supervisoresx */
			$qry ="SELECT * FROM tbl_supervisores WHERE su_fi_id=".$cod.";";

			$resp = mysql_query($qry);
			$cant=mysql_num_rows($resp);
			if($cant>0){
				$item='';
				while($row_resp = mysql_fetch_assoc($resp)){
					$item.='<option value="'.$row_resp["su_id"].'">'.$row_resp["su_nombre"].'</option>';
				}	

				$html='
			        <select class="form-control valued" id="sup">
			          '.$item.'
			        </select>
			        <label for="sup" class="">Supervisor</label>
			    ';
				$res=true;
				$mes=$html;


			}else{
				$res=false;
				$mes=$msg->get_msg("e010");
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
          case 'get_supervisores' : supervisores();break;
      }
  }
?>