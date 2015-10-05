<?php
require_once("funciones.php");
require_once("messages.php");


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
        echo "<br>Subnucleo nro: ".$res_sn[$i]["sn_id"];
        echo "=> ".$res_sn[$i]["sn_subnucleo"]."<br>";
        
        //traemos conductores asociados
        $qry_con = 'SELECT * FROM tbl_personas WHERE 
                    pe_f1 = '.$res_sn[$i]["sn_id"].' OR 
                    pe_f2 = '.$res_sn[$i]["sn_id"].';';

        /*HACE FALTA LA DOBLE VALIDACIÓN DE QUE ESTE NO ESTÉ ASIGNADO O SUGERIDO A OTRA FINCA*/

        $res_con = $fun->get_array($qry_con);
        echo "<br> cantidad de conductores: ";
        echo count($res_con);
    
        //para cada subnucleo, listamos sus respectivas fincas
        $qry_fin = 'SELECT * FROM tbl_fincas WHERE fi_sn_id = '.$res_sn[$i]["sn_id"].';';
        $res_fin = $fun->get_array($qry_fin);

        //traemos inventarios por cada finca
        $cant_fin = count($res_fin);
        echo "<br> cantidad de fincas: ".$cant_fin;
        $arr_inv = array();

        for ($j=0; $j < $cant_fin; $j++) { 
          $qry_inv = 'SELECT * FROM tbl_inventario WHERE in_fi_id = '.$res_fin[$j]["fi_id"].';';
          //echo "<br>[".$qry_inv."]<br>";
          //$qry_inv = 'SELECT * FROM tbl_inventario WHERE in_fi_id = '.$res_fin[$j]["fi_id"].' OR in_timestamp BETWEEN "'.$hoy.' 00:00:00" AND "'.$hoy.' 23:59:59";';
          $res_inv = $fun->get_array($qry_inv);
          $arr_inv[$j]=$res_inv;
          //print_r($res_inv);
        }
        $cant_inv = count($arr_inv,1);
        $cant_inv = floor($cant_inv/10);

        echo "<br> cantidad de inventarios de este subnucleo:";
        echo ($cant_inv)."<br>";
        if($cant_inv>0){
          echo "<br> inventarios de este subnucleo: <br>";
          for ($k=0; $k < $cant_inv; $k++) { 
            echo "<br> Inventario ".$k.": ";
            print_r($arr_inv[$k]);
            echo "<br>";
          }
        }
        echo "<br>//<br>";
        print_r($arr_inv);
        echo "<br>//<br>";


        


        unset($arr_inv);
        echo "<br>+++++++++++++++++++++++++++++++++++++++++++++++++++++++<br>";

        
      }
    }


    $con->disconnect();
  }
programar_rutas();
?>