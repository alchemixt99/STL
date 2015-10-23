<?php
require_once("funciones.php");
require_once("messages.php");
class supervisores{

  function get_supervisores(){
    $con = new con();
    $msg = new messages();
    $rt = new route();

    $con->connect();

    //consultamos usuarios
    if(isset($_SESSION["ses_id"])){
      $qry='SELECT * FROM tbl_supervisores AS S
            INNER JOIN tbl_fincas AS F ON F.fi_id = S.su_fi_id
            WHERE S.su_estado=1;';
      $res = mysql_query($qry);

      $item =" ";
      $script ="<script>$(document).ready(function(){";
      while($row_res = mysql_fetch_assoc($res)) {
        $fn = "editar_usuario(".$row_res["su_id"].", '".$row_res["su_nombre"]."',".$row_res["su_fi_id"].", this)";
        $item.='
              <tr>
                <td>'.$row_res["su_nombre"].'</td>
                <td>'.$row_res["fi_codigo"].'</td>
                <td>'.$row_res["fi_timestamp"].'</td>
                <td>
                  <div onClick="'.$fn.'" class="btn btn-floating-mini btn-success" title="Modificar"><i class="md md-edit"></i> </div>
                  <div id="del-button" onClick="borrar_usuario('.$row_res["su_id"].', this)" class="btn btn-floating-mini btn-danger" title="Borrar"><i class="md md-delete"></i> </div>
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