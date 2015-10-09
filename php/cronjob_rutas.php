<?php
session_start();
require_once("funciones.php");
require_once("messages.php");

if(isset($_SESSION["ses_id"])){
//if(!$fun->isAjax()){header ("Location: ../../mods/panel/panel.php");}

  function programar_rutas(){
    $con = new con();
    $msg = new messages();
    $fun = new funciones();

    $con->connect();
    //Fecha
    date_default_timezone_set("America/Bogota"); 
    $fecha = date('Y-m-d G:i:s');
    $hoy = date('Y-m-d');
    echo "<h1>Informe, generacion de rutas</h1>";
    echo "<br>Fecha ".$fecha."<br>";

    //traemos subnucleos
    $qry_sn ="SELECT * FROM tbl_subnucleos ORDER BY sn_id ASC";
    $res_sn=$fun->get_array($qry_sn);
    if(!$res_sn){echo $msg->get_msg("e025");}
    else{
      //($res_sn);
      //cantidad de sn:
      $cant_sn = count($res_sn);
      echo "Total Subnucleos: ".$cant_sn."<br>";
      for ($i=0; $i < $cant_sn; $i++) { 
        echo "<h1>Subnucleo nro: ".$res_sn[$i]["sn_id"]."";
        echo "=> ".$res_sn[$i]["sn_subnucleo"]."</h1><br>";
        
        //traemos conductores asociados
        $qry_con = 'SELECT * FROM tbl_personas 
        			INNER JOIN tbl_vehiculos ON ve_id = pe_ve_id
        			WHERE 
                pe_f1 = '.$res_sn[$i]["sn_id"].' OR 
                pe_f2 = '.$res_sn[$i]["sn_id"].'
              ;';
        //echo $qry_con;
        /*HACE FALTA LA DOBLE VALIDACIÓN DE QUE ESTE NO ESTÉ ASIGNADO O SUGERIDO A OTRA FINCA*/

        $res_con = $fun->get_array($qry_con);
        $cant_con = count($res_con);
        echo "<br> cantidad de conductores: ".$cant_con;
    
        //para cada subnucleo, listamos sus respectivas fincas
        $qry_fin = 'SELECT * FROM tbl_fincas WHERE fi_sn_id = '.$res_sn[$i]["sn_id"].';';
        $res_fin = $fun->get_array($qry_fin);

        //traemos inventarios por cada finca
        $cant_fin = count($res_fin);
        echo "<br> cantidad de fincas: ".$cant_fin."<br>";
        $arr_inv = array();
        $pos = 0;
        $c=0;
        for ($j=0; $j < $cant_fin; $j++) { 
          $qry_inv = 'SELECT * FROM tbl_inventario WHERE in_fi_id = '.$res_fin[$j]["fi_id"].' AND in_mt_restante > 0 AND in_estado=1;';
          $res_inv = $fun->get_array($qry_inv);
          $c = count($res_inv);
          if($c>1){
          	$pos = $pos + $c;
          	for ($k=0; $k < $pos; $k++) { 
          		$arr_inv[$k]=$res_inv[$k];
          	}
          }
          if($c==1){
          	$arr_inv[$pos]=$res_inv[0];
          	$pos++;
          }
        }
        $cant_inv = count($arr_inv);

        echo "<br> <h4>cantidad de inventarios de este subnucleo: ".$cant_inv."</h4>";
        /*echo "<pre>";
        print_r($arr_inv);
        echo "</pre>";*/
        
        //traemos turnos
        $qry_tur = 'SELECT * FROM tbl_turnos ORDER BY tu_id ASC';
        $res_tur = $fun->get_array($qry_tur);

        //variables de sesión para cada inventario
        for ($ci=0; $ci < $cant_inv; $ci++) { 
          $id_inv = $arr_inv[$ci]["in_id"];
          $_SESSION[$id_inv]["inv_rest"] = $arr_inv[$ci]["in_mt_restante"];

          //echo "<br>prueba variable sesion".$_SESSION[$id_inv]["inv_rest"];
        }


        //recorremos arreglo y vamos asignando conductores 
        if ($cant_inv>0) {
		    $turno = 0;
		    $tg=0;
        	for ($doblete=0; $doblete < 2; $doblete++) { 
		        $end=false;
		        $l=0;
		        while($end==false){
		        	for ($m=0; $m < $cant_inv; $m++) { 
		        		if($l==$cant_con){$end=true; break;}
		        		//traemos inventario restante
                //$inv_rest = $fun->get_custom("SELECT in_mt_restante FROM tbl_inventario WHERE in_id=".$arr_inv[$m]["in_id"]);
		        		$inv_rest = $_SESSION[$arr_inv[$m]["in_id"]]["inv_rest"];
		        		if($inv_rest>0){
		        			$inv_nuevo = $inv_rest-$res_con[$l]["ve_capacidad_m3"];
		        			if($inv_nuevo>=0){
			        			echo "<pre>";
				        		echo "<br> ----> [".$l."] asignando cond ".$res_con[$l]["pe_id"]." (cap. ".$res_con[$l]["ve_capacidad_m3"]."m<sup>3</sup>) a inventario ".$arr_inv[$m]["in_id"]." en el turno (".$turno."): ".$res_tur[$turno]["tu_hora_ini"]."
				        			inventario restante: ".$inv_nuevo;
				        		echo "<br><strong>Actualización de inventario tbl_inventario, in_mt_restante =".$inv_nuevo."</strong> => resultado: ";
                    //$upd_vol = $fun->actualizar("inventario", "in_mt_restante =".$inv_nuevo, "in_id = ".$arr_inv[$m]["in_id"]);
                    $_SESSION[$arr_inv[$m]["in_id"]]["inv_rest"] = $inv_nuevo;
                    
                    //cargamos en despachos como sugerencia [estado=1]
                    $tbl_des = 'despachos';
                    $fld_des = 'de_pe_id, de_ve_capacidad_m3, de_in_id, de_tu_id, de_inv_rest, de_created, de_estado';
                    $val_des = $res_con[$l]["pe_id"].','.$res_con[$l]["ve_capacidad_m3"].','.$arr_inv[$m]["in_id"].','.$res_tur[$turno]["tu_id"].','.$inv_nuevo.','.$_SESSION["ses_id"].',1';
                    $res_des = $fun->crear($tbl_des, $fld_des, $val_des);
                    //echo "<br>Probando SESSION VAR: inventario restante del inventario (".$arr_inv[$m]["in_id"].") :".$_SESSION[$arr_inv[$m]["in_id"]]["inv_rest"]."<br>";
			        			$res_des = true;
			        			if($res_des){$tg++; }else{echo "(error)";}
			        		}
			        	}else{
			        		$m++;
			        	}
			        	$l++;
		        	}
		        	$turno++;
		        }
        	}
        echo "<h3>Total turnos generados: ".$tg."</h3>";
        }

        


        unset($arr_inv);
        echo "<br>+++++++++++++++++++++++++++++++++++++++++++++++++++++++<br>";

        
      }
    }


    $con->disconnect();
  }
programar_rutas();
}else
{
  header ("Location: ../mods/panel/panel.php");
}
?>