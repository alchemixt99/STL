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

        $btn_des = "des_persona('".$row_res["pe_id"]."',this)";
        $btn_act = "act_persona('".$row_res["pe_id"]."',this)";
        $btn_del = "del_persona('".$row_res["pe_id"]."',this)";

        if($row_res["pe_estado"]==1 && $row_res["pe_tipo"]!=1 ){
          $btn_set = '<div id="edt-button" style="display:none;" onclick="" class="btn btn-floating-mini btn-success" title="Modificar"><i class="md  md-edit"></i></div>
                      <div id="des-button" onclick="'.$btn_des.'" class="btn btn-floating-mini btn-warning" title="Deshabilitar"><i class="md  md-visibility-off"></i></div>
                      <div id="del-button" onclick="'.$btn_del.'" class="btn btn-floating-mini btn-danger" title="Borrar"><i class="md  md-delete"></i></div>';
        }
        elseif($row_res["pe_estado"]==2 && $row_res["pe_tipo"]!=1 ){
          $btn_set = '<div id="edt-button" style="display:none;" onclick="" class="btn btn-floating-mini btn-success" title="Modificar"><i class="md  md-edit"></i></div>
                      <div id="act-button" onclick="'.$btn_act.'" class="btn btn-floating-mini btn-warning" title="Habilitar"><i class="md  md-visibility"></i></div>
                      <div id="del-button" onclick="'.$btn_del.'" class="btn btn-floating-mini btn-danger" title="Borrar"><i class="md  md-delete"></i></div>';
        }else{
          $btn_set = '<div id="edt-button" style="display:none;" onclick="" class="btn btn-floating-mini btn-success" title="Modificar"><i class="md  md-edit"></i></div>
                      <div id="del-button" onclick="'.$btn_del.'" class="btn btn-floating-mini btn-danger" title="Borrar"><i class="md  md-delete"></i></div>';
        }
        $item.='
              <tr id="'.$row_res["pe_cedula"].'">
                <td>'.$row_res["pe_cedula"].'</td>
                <td>'.$row_res["pe_nombre"].'</td>
                <td>'.$row_res["pe_tel"].' - '.$row_res["pe_cel"].'</td>
                <td>'.$row_res["pe_dir"].'</td>
                <td>'.$lic.'</td>
                <td>
                  '.$btn_set.'
                </td>
              </tr>

        ';
        switch ($row_res["pe_estado"]) {
          case 2:
            $script.='$("#'.$row_res["pe_cedula"].'").addClass("danger");';
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