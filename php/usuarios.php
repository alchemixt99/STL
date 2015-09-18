<?php
require_once("funciones.php");
require_once("messages.php");
class usuarios{

  function get_usuarios(){
    $con = new con();
    $msg = new messages();
    $rt = new route();

    $con->connect();

    //consultamos usuarios
    if(isset($_SESSION["ses_id"])){
      $qry='SELECT * FROM tbl_usuarios AS U
            INNER JOIN tbl_per_x_usu AS PxU ON PxU.pxu_us_id = U.us_id
            INNER JOIN tbl_permisos AS P ON P.pe_id = PxU.pxu_pe_id
            WHERE U.us_estado=1;';
      $res = mysql_query($qry);

      $item =" ";
      $script ="<script>$(document).ready(function(){";
      while($row_res = mysql_fetch_assoc($res)) {
        //segun sea el tipo de usuario: 
        switch ($row_res['pe_permiso']) {
          case 1: //superadmin
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
        }
        $fn = 
        $item.='
              <tr>
                <td>'.$row_res["us_cc"].'</td>
                <td>'.$row_res["us_nombre"].'</td>
                <td>'.$icon.'</td>
                <td>'.$row_res["us_timestamp"].'</td>
                <td>
                  <div id="edt-button" style="display:none" onClick="load_modal('.$row_res["us_id"].', '.$row_res["pe_permiso"].');" class="btn btn-raised btn-primary" title="Permisos"><i class="md md-label"></i> Permisos </div>
                  <div onClick="cambiar_clave('.$row_res["us_id"].')" class="btn btn-floating-mini btn-link" data-ripple-centered="" title="Cambiar Clave"><i class="md md-https"></i></div>
                  <div id="del-button" onClick="borrar_usuario('.$row_res["us_id"].', this)" class="btn btn-floating-mini btn-danger" title="Borrar"><i class="md md-delete"></i> </div>
                </td>
              </tr>
        ';
        $script.='';
      }
      $script.='});</script>';
    }
    else{$rt->routing($rt->path("login"));}

    $html='
          <table class="table table-striped table-hover ">
            <thead>
              <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Perfil</th>
                <th>Fecha Registro</th>
                <th>Opciones</th>
              </tr>
            </thead>
            <tbody>
              '.$item.'
            </tbody>
          </table> 
    ';
    $con->disconnect();
    return $script.$html;
  }
  function get_options_fincas(){
    $con = new con();
    $msg = new messages();
    $rt = new route();

    $con->connect();


    //consultamos fincas desde la matriz ica
    if(isset($_SESSION["ses_id"])){
      $qry='SELECT DISTINCT codfinca, municipio, depto FROM tbl_matriz_ica ORDER BY codfinca ASC';
      $res = mysql_query($qry);

      $item =" ";
      $script ="<script>$(document).ready(function(){";
      while($row_res = mysql_fetch_assoc($res)) {
        $item.='
              <option value="'.$row_res["codfinca"].'">'.$row_res["codfinca"].' ('.$row_res["municipio"].' - '.$row_res["depto"].')</option>
        ';
        $script.='';
      }
      $script.='});</script>';
    }
    else{$rt->routing($rt->path("login"));}

    $html='
        <select class="form-control valued" id="cod">
          '.$item.'
        </select>
    ';
    $con->disconnect();
    return $script.$html;
  }
}
?>