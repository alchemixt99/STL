<?php
require_once("funciones.php");
require_once("messages.php");
class aside_menu{
  function build_menu_aside(){
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
        $cargo = $row_res['pe_descripcion'];
        $nombre = $row_res['us_nombre'];
      }
      $script.='});</script>';
    }
    else{$rt->routing($rt->path("login"));}

    $html='
	    <nav class="navbar-panel">
	      <div class="header container-fluid mtr-cyan-900">
	        <div class="row">
	          <div class="col-xs-12">
	            <h4><b>'.$nombre.'</b></h4>
	            <h1></h1>
	            <h4>'.$cargo.'</h4>
	          </div>
	        </div>
	      </div>

	      <div class="content mtr-grey-100">
	        <ul class="nav">
	          <li><a href="#" id="btn_logout">Salir</a></li>
	        </ul>
	      </div>
	    </nav>
    ';
    $con->disconnect();
    return $html;
  }
}
?>