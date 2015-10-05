<?php
session_start();
require("funciones.php");
require("messages.php");

$fun = new funciones();
if(!$fun->isAjax()){header ("Location: ../../mods/panel/panel.php");}

  //=============Definimos funciones===================
	//construimos los turnos según sea el inventario y los conductores
	function get_turno_cond(){	
		$fun = new funciones();
		$msg = new messages();
		$response = new StdClass;

		/*recibimos variables*/
		$fecha=$_POST["f"];
		$placa = $_POST["p"];

		$con = new con();
		$con->connect();

		//traer información del conductor segun sea la fecha
		
		$res=true;
		$mes=$msg->get_msg("e003");

		$con->disconnect();
		
		$response->res = $res;
		$response->mes = $mes;
		echo json_encode($response);
	}

	//construimos los valores a cargar en el modal
	function get_modal_values(){	
		$fun = new funciones();
		$msg = new messages();
		$response = new StdClass;

		/*recibimos variables*/
		$cod=$_POST["cod"];
		$lot=$_POST["lot"];

		$con = new con();
		$con->connect();

		/* ingresamos datos de la finca */
		$item="<option>Seleccione Inventario</option>";
		$qry_lotes ='SELECT * FROM tbl_inventario AS I
					INNER JOIN tbl_fincas AS F ON F.fi_id=I.in_fi_id
					INNER JOIN tbl_lotes_autorizados AS L ON L.la_id=I.in_lote
					WHERE in_fi_id ='.$cod.' AND in_lote = '.$lot.';';
		//echo $qry_lotes;
		$res_lotes = mysql_query($qry_lotes);
		while($row_lotes = mysql_fetch_assoc($res_lotes)) {
			$item.='<option value="'.$row_lotes['in_id'].'">Finca: '.$row_lotes['fi_codigo'].' - Lote: '.$row_lotes['la_idlote'].' ('.$row_lotes['in_mt_cubico'].' m<sup>3</sup>) </option>';
		}
		$scr='
		<script>
		  //acción al cambiar el select id=inv
	      $("#combo_inv").on("change", function(){
      		$("#progress").fadeIn();
	        $.ajax({      
	          url: "../../php/ajax_rutas.php",     
	          dataType: "json",     
	          type: "POST",     
	          data: { 
	                  action: "get_turnos",
	                  cod_inv: $("#combo_inv").val(),
	                  fin: $("#cod_finca").val()
	                },
	          success: function(data){    
	            if(data.res==true){
	              $("#turnos_box").fadeIn();
	              $("#turnos_box").html(data.mes);
      			  $("#progress").fadeOut();
	            }
	          }
	        });
	      });

		</script>';
		$html = '<select class="form-control" id="combo_inv">
	            '.$item.'
	             </select>';
		$res=true;
		$mes=$scr.$html;
				
		$con->disconnect();
		
		$response->res = $res;
		$response->mes = $mes;
		echo json_encode($response);
	}

	function add_route(){
		$fun = new funciones();
		$msg = new messages();
		$response = new StdClass;

		/*recibimos variables*/
		$turno = $_POST['turno'];
     	$condu = $_POST['condu'];
    	$inven = $_POST['inven'];
    	$capac = $_POST['capac'];

		$con = new con();
		$con->connect();

		$values=$turno.",".$condu.",".$inven.",".$capac.",".$_SESSION["ses_id"].",1";
		$res=$fun->crear("despachos", "de_tu_id, de_pe_id, de_in_id, de_vol, de_created, de_estado", $values);

		$mes=null;
				
		$con->disconnect();
		
		$response->res = $res;
		$response->mes = $mes;
		echo json_encode($response);

	}

  //validamos si es una petición ajax
  if(isset($_POST['action']) && !empty($_POST['action'])) {
      $action = $_POST['action'];
      switch($action) {
          case 'save' : add_finca();break;
          case 'get_rutas' : get_modal_values();break;
          case 'save_rutas' : add_route();break;
          case 'get_info_cond' : get_turno_cond();break;
      }
  }
?>