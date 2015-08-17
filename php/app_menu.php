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
        //$menuitem.='<li><a href="'.$row_res['mo_ruta'].'" class="">'.$row_res['mo_nombre'].'</a></li>';
        $menuitem.='<li><a href="#" id="'.$row_res['mo_nombre'].'" class="">'.$row_res['mo_nombre'].'</a></li>';
        $script.='$("#'.$row_res['mo_nombre'].'").on("click", function(){$(location).attr("href","'.$row_res['mo_ruta'].'"); });';
      }
      $script.='});</script>';
    }
    else{$rt->routing($rt->path("login"));}

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
                    
                    <li><a href="#" class="">fecha / hora</a></li>
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