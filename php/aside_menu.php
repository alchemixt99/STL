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
            AND U.us_id = '.$_SESSION["ses_id"].' LIMIT 1';
      $res = mysql_query($qry);
      $menuitem =" ";
      $script ="<script>$(document).ready(function(){";
      while($row_res = mysql_fetch_assoc($res)) {
        $cargo = $row_res['pe_descripcion'];
        $nombre = $row_res['us_nombre'];
        //si es superadmin, le habilitamos el menú de gestión de usuarios y permisos
        switch ($row_res['pe_permiso']) {
          case 1://superAdmin
              $script.='$("#usuarios").on("click", function(){$(location).attr("href","../users/users.php"); });';
              $script.='$("#reportar").on("click", function(){$(location).attr("href","../reportar/reportar.php"); });';
              $menuitem.='<li><a href="#" id="usuarios" class=""><i class="md md-user"></i>Usuarios</a></li>';
              $menuitem.='<li><a href="#" id="reportar" class=""><i class="md md-user"></i>Reportar Consecutivo</a></li>';
              $icon='<a href="#" class="btn btn-floating-mini btn-warning" title="'.$row_res['pe_descripcion'].'" data-ripple-centered=""><i class="md md-account-circle"></i></a>';
            break;
          case 2: //Jefeop
              $icon='<a href="#" class="btn btn-floating-mini btn-primary" title="'.$row_res['pe_descripcion'].'" data-ripple-centered=""><i class="md md-account-circle"></i></a>';
            break;
          case 3: //Digit
              $icon='<a href="#" class="btn btn-floating-mini btn-success" title="'.$row_res['pe_descripcion'].'" data-ripple-centered=""><i class="md md-account-circle"></i></a>';
            break;
          case 4: //Gerente
              $icon='<a href="#" class="btn btn-floating-mini btn-warning" title="'.$row_res['pe_descripcion'].'" data-ripple-centered=""><i class="md md-account-circle"></i></a>';
            break;
          
          default:
            $menuitem="";
            break;
        }
        /*$tipo_us = $row_res['pxu_pe_id'];
        //$menuitem.='<li><a href="'.$row_res['mo_ruta'].'" class="">'.$row_res['mo_nombre'].'</a></li>';
        $menuitem.='<li><a href="#" id="'.$row_res['mo_nombre'].'" class="">'.$row_res['mo_descripcion'].'</a></li>';
        $script.='$("#'.$row_res['mo_nombre'].'").on("click", function(){$(location).attr("href","'.$row_res['mo_ruta'].'"); });';
        */
      }
      $script.='});</script>';
    }
    else{$rt->routing($rt->path("login"));}

    $html='
	    <nav class="navbar-panel">
	      <div class="header container-fluid mtr-cyan-900">
	        <div class="row">
	          <div class="col-xs-12">
              <h1 style="text-align:center; padding-top:6px; margin-bottom: 6px;">'.$icon.'</h1>
              <h4 style="margin-top: 1px;"><b>'.$nombre.'</b> <br> <span style="font-style:italic; font-size:13px;">'.$cargo.'<span></h4>
              <h4></h4>
	          </div>
	        </div>
	      </div>

	      <div class="content mtr-grey-100">
	        <ul class="nav">
            '.$menuitem.'
	          <li><a href="#" id="btn_logout">Salir</a></li>
	        </ul>
	      </div>
	    </nav>
    ';
    $con->disconnect();
    return $script.$html;
  }
}
?>