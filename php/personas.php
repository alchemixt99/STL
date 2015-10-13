<?php
require_once("funciones.php");
require_once("messages.php");
class personas{

  function get_personas(){
    $con = new con();
    $msg = new messages();
    $rt = new route();

    $con->connect();


    //consultamos Inventarios
    if(isset($_SESSION["ses_id"])){
      $qry='SELECT * FROM tbl_personas 
            WHERE pe_estado BETWEEN 1 AND 2 ORDER BY pe_nombre ASC';
      $res = mysql_query($qry);

      $item =" ";
      $script ="<script>$(document).ready(function(){";
      while($row_res = mysql_fetch_assoc($res)) {
        if ($row_res["pe_tipo"]==1) {$lic = '';}
        else{$lic = $row_res["pe_licencia"].' - ('.$row_res["pe_licencia_vigencia"].')';}
        $item.='
              <tr id="'.$row_res["pe_cedula"].'">
                <td>'.$row_res["pe_cedula"].'</td>
                <td>'.$row_res["pe_nombre"].'</td>
                <td>'.$row_res["pe_tel"].' - '.$row_res["pe_cel"].'</td>
                <td>'.$row_res["pe_dir"].'</td>
                <td>'.$lic.'</td>
                <td>
                  <div id="edt-button" style="display:none;" onclick="" class="btn btn-floating-mini btn-success" title="Modificar"><i class="md  md-edit"></i></div>
                  <div id="del-button" onclick="" class="btn btn-floating-mini btn-danger" title="Borrar"><i class="md  md-delete"></i></div>
                </td>
              </tr>

        ';
        switch ($row_res["pe_estado"]) {
          case 2:
            $script.='$("#'.$row_res["pe_cedula"].'").addClass("danger");';
            break;
          
          default:
            # code...
            break;
        }
        $script.='$("#'.$row_res["pe_cedula"].'").addClass();';
      }
      $script.='});</script>';
    }
    else{$rt->routing($rt->path("login"));}

    $html='
          <table class="table table-striped table-hover ">
            <thead>
              <tr>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Tel - Cel</th>
                <th>Domicilio</th>
                <th>Licencia</th>
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