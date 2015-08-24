<?php
require_once("funciones.php");
require_once("messages.php");
class rfisicas{

  function get_rfisicas(){
    $con = new con();
    $msg = new messages();
    $rt = new route();

    $con->connect();


    //consultamos fincas
    if(isset($_SESSION["ses_id"])){
      $qry='SELECT * FROM tbl_remisiones_fisicas WHERE rf_estado=1 ORDER BY rf_timestamp DESC ';
      $res = mysql_query($qry);

      $item =" ";
      $script ="<script>$(document).ready(function(){";
      while($row_res = mysql_fetch_assoc($res)) {
        //calculamos porcentaje de uso
          $porcentaje=(($row_res["rf_cant_usados"]*100)/($row_res["rf_dig_fin"]-$row_res["rf_dig_ini"]));
        //--
        $item.='
              <tr>
                <td>'.$row_res["rf_timestamp"].'</td>
                <td>'.$row_res["rf_tipo_doc"].'</td>
                <td>'.$row_res["rf_dig_ini"].'</td>
                <td>'.$row_res["rf_dig_fin"].'</td>
                <td><div class="progress progress-striped active">
                      <div class="progress-bar" title="'.$row_res["rf_cant_usados"].'  ('.$porcentaje.'%)" style="width: '.$porcentaje.'%; height:10px;"></div>
                    </div>
                </td>
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
                <th>Fecha Registro</th>
                <th>Documento</th>
                <th>Inicia</th>
                <th>Termina</th>
                <th>Usados</th>
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