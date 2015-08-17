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
            INNER JOIN tbl_fincas AS F
            ON I.in_fi_id = F.fi_id ORDER BY I.in_codigo ASC ';
      $res = mysql_query($qry);

      $item =" ";
      $script ="<script>$(document).ready(function(){";
      while($row_res = mysql_fetch_assoc($res)) {
        $item.='
              <tr>
                <td>'.$row_res["fi_codigo"].'</td>
                <td>'.$row_res["in_mt_cubico"].'</td>
                <td>'.$row_res["in_lote"].'</td>
                <td>'.$row_res["in_tipo_materia"].'</td>
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
                <th>Código Finca</th>
                <th>M3</th>
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
}
?>