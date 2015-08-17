<?php
require_once("funciones.php");
require_once("messages.php");
class fincas{

  function get_fincas(){
    $con = new con();
    $msg = new messages();
    $rt = new route();

    $con->connect();


    //consultamos fincas
    if(isset($_SESSION["ses_id"])){
      $qry='SELECT * FROM tbl_fincas WHERE fi_estado=1 ORDER BY fi_codigo ASC ';
      $res = mysql_query($qry);

      $item =" ";
      $script ="<script>$(document).ready(function(){";
      while($row_res = mysql_fetch_assoc($res)) {
        $item.='
              <tr>
                <td>'.$row_res["fi_codigo"].'</td>
                <td>'.$row_res["fi_nombre"].'</td>
                <td>'.$row_res["fi_supervisor"].'</td>
                <td>'.$row_res["fi_ciudad"].'</td>
                <td>'.$row_res["fi_dir"].'</td>
                <td>'.$row_res["fi_tel"].'</td>
                <td>
                  <div id="edt-button" onclick="" class="btn btn-floating-mini btn-success" title="Modificar"><i class="md  md-edit"></i></div>
                  <div id="del-button" onclick="" class="btn btn-floating-mini btn-danger" title="Borrar"><i class="md  md-delete"></i></div>
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
                <th>Código</th>
                <th>Nombre</th>
                <th>Supervisor</th>
                <th>Ciudad</th>
                <th>Telefono</th>
                <th>Dirección</th>
                <th>Acciones</th>
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
}
?>