<?php
require_once("funciones.php");
require_once("messages.php");
class inventarios{

  function get_inventario(){
    $con = new con();
    $msg = new messages();
    $rt = new route();

    $con->connect();

    //consultamos Inventarios
    if(isset($_SESSION["ses_id"])){
      $qry='SELECT * FROM tbl_inventario AS I
            INNER JOIN tbl_fincas AS F ON I.in_fi_id = F.fi_id
            INNER JOIN tbl_supervisores AS S ON S.su_id = I.in_supervisor
            WHERE I.in_estado<99
            ORDER BY F.fi_codigo ASC';
      $res = mysql_query($qry);

      $item =" ";
      $script ="<script>$(document).ready(function(){";
      while($row_res = mysql_fetch_assoc($res)) {
        if($row_res["in_tipo_materia"]==1){$tipo_materia="Troza";}else{$tipo_materia="Pulpa";}
        $item.='
              <tr>
                <td>'.$row_res["fi_codigo"].'</td>
                <td>'.$row_res["su_nombre"].'</td>
                <td>'.$row_res["in_mt_cubico"].' m<sup>3</sup></td>
                <td>'.$row_res["in_lote"].'</td>
                <td>'.$tipo_materia.'</td>
                <td>
                  <div id="del-button" onclick="borrar_inv('.$row_res["in_id"].', this)" class="btn btn-floating-mini btn-danger" title="Borrar"><i class="md  md-delete"></i></div>
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
                <th>Código Finca</th>
                <th>Supervisor</th>
                <th>Inventario</th>
                <th>Lote</th>
                <th>Tipo Madera</th>
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

  //LISTADO DE FINCAS [combo]
  function get_fincas_list(){
    $con = new con();
    $msg = new messages();
    $rt = new route();

    $con->connect();


    //consultamos fincas desde la tabla de fincas
    if(isset($_SESSION["ses_id"])){
      $qry='SELECT * FROM tbl_fincas WHERE fi_estado=1 ORDER BY fi_nombre ASC';
      $res = mysql_query($qry);

      $item =" ";
      $script ="<script>$(document).ready(function(){";
      while($row_res = mysql_fetch_assoc($res)) {
        $item.='
              <option value="'.$row_res["fi_id"].'">'.$row_res["fi_codigo"].'</option>
        ';
        $script.='';
      }
      $script.='});</script>';
    }
    else{$rt->routing($rt->path("login"));}

    $html='
        <select class="form-control valued" id="cod">
          <option>Seleccione</option>
          '.$item.'
        </select>
    ';
    $con->disconnect();
    return $script.$html;
  }

}
?>