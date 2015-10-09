<?php
session_start();
require_once("funciones.php");
require_once("messages.php");

if(isset($_SESSION["ses_id"])){
//if(!$fun->isAjax()){header ("Location: ../../mods/panel/panel.php");}

  function asignar_ica(){
    $con = new con();
    $msg = new messages();
    $fun = new funciones();

    $con->connect();
    //Fecha
    date_default_timezone_set("America/Bogota"); 
    $fecha = date('Y-m-d G:i:s');
    $filename = date('YmdGis');
    $filename.= ".html";
    $content = "";

    $hoy = date('Y-m-d');

    $content.= "<h1>Informe, asignación de código ICA</h1>";
    $content.= "<br>Fecha ".$fecha."<br>";
    $content.= "<br>Archivo generado: ".$filename."<br>";

    //traemos listado de despachos aprobados
    $qry_des = 'SELECT * FROM tbl_despachos WHERE de_estado=2';
    $arr_des = $fun->get_array($qry_des);

    $can_des = count($arr_des);
    $content.= "cantidad de despachos aprobados: ".$can_des;
    //$fun->print_array($arr_des);

    for ($i=0; $i < $can_des; $i++) { 
      $content.= "<pre>";
      $content.= "<br> Despacho #".$i;
      // traemos el último ica disponible del paquete autorizado
      $qry_rem = 'SELECT * FROM tbl_remisiones_fisicas WHERE rf_estado = 99 LIMIT 1;';
      $arr_rem = $fun->get_array($qry_rem);
      $content.= "<br>  ->cantidad de consecutivos usados: ".$arr_rem[0]['rf_cant_usados'];
      $restantes = $arr_rem[0]['rf_dig_fin']-$arr_rem[0]['rf_cant_usados'];
      if($restantes>0){
        $content.= "<br>  ->consecutivos restantes: ".$restantes;
        $cons = ($arr_rem[0]['rf_dig_fin'] - $restantes)+1;
        $content.= "<br>  ->consecutivo a usar: ".$cons;

        // lo asignamos al despacho actual
        

        // guardamos

        $content.= "</pre>";

        // generamos informe
        //$fun->create_file($content, $filename);
      }

    }

    echo $content;


    $con->disconnect();
  }
asignar_ica();
}else
{
  header ("Location: ../mods/panel/panel.php");
}
?>