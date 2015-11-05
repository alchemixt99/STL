<?php
require_once("funciones.php");
require_once("messages.php");
class app_menu{
  function build_menu(){
    $con = new con();
    $msg = new messages();
    $rt = new route();

    $con->connect();


    //consultamos sesión del usuario
    if(isset($_SESSION["ses_id"])){
      $qry='SELECT * FROM tbl_modulos AS M
            INNER JOIN tbl_usuarios AS U
            INNER JOIN tbl_permisos AS P
            INNER JOIN tbl_per_x_usu AS PxU
            INNER JOIN tbl_permisos_x_modulo AS PxM
            WHERE M.mo_id = PxM.pxm_mo_id 
            AND PxM.pxm_pe_id = P.pe_id
            AND P.pe_id = PxU.pxu_pe_id
            AND PxU.pxu_us_id = U.us_id
            AND U.us_id = '.$_SESSION["ses_id"];
      $res = mysql_query($qry);
      $menuitem =" ";
      $script ="<script>$(document).ready(function(){";
      while($row_res = mysql_fetch_assoc($res)) {
        $tipo_us = $row_res['pxu_pe_id'];
        //$menuitem.='<li><a href="'.$row_res['mo_ruta'].'" class="">'.$row_res['mo_nombre'].'</a></li>';
        $menuitem.='<li><a href="#" id="'.$row_res['mo_nombre'].'" class="">'.$row_res['mo_descripcion'].'</a></li>';
        $script.='$("#'.$row_res['mo_nombre'].'").on("click", function(){$(location).attr("href","'.$row_res['mo_ruta'].'"); });';
      }
      $script.='});</script>';
    }
    else{$rt->routing($rt->path("login"));}

    //generamos menú tipo dropdown para el usuario gerente
    if($tipo_us==1){
      $dropdown = '<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Gestionar <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                    '.$menuitem.'
                    </ul>
                  </li>
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Reportes <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="reportes.php" target="_blank" id="" class="">Reporte de Consecutivos ICA generados</a></li>              
                      <li><a href="reportes.php" target="_blank" id="" class="">Reporte de Despachos Generados</a></li>              
                      <li><a href="reportes.php" target="_blank" id="" class="">Reporte de Estado de los lotes</a></li>              
                    </ul>
                  </li>
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Programación (Cronjobs) <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="reportes.php" target="_blank" id="" class="">Despachos</a></li>              
                      <li><a href="reportes.php" target="_blank" id="" class="">Consecutivos ICA</a></li>              
                    </ul>
                  </li>';
      $menuitem=$dropdown;      
    }

    $html='
            <nav class="navbar navbar-inverse">
              <div class="container-fluid">
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                  <ul class="nav navbar-nav">
                  '.$menuitem.'
                  </ul>
                  <ul class="nav navbar-nav navbar-right">
                    
                    <li><a href="#" id="reloj">fecha / hora</a></li>
                  </ul>
                </div>
              </div>
            </nav>
    ';
    $con->disconnect();
    return $script.$html;
  }
}
?>