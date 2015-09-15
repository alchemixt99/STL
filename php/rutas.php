<?php
require_once("funciones.php");
require_once("messages.php");
class rutas{

  function get_fincas(){
    $con = new con();
    $msg = new messages();
    $rt = new route();

    $con->connect();


    //consultamos fincas
    if(isset($_SESSION["ses_id"])){
      $qry='SELECT * FROM tbl_control_inventarios
            INNER JOIN tbl_fincas ON tbl_fincas.fi_id=tbl_control_inventarios.ci_fi_id 
            INNER JOIN tbl_lotes_autorizados ON tbl_lotes_autorizados.la_id = tbl_control_inventarios.ci_in_lote
            INNER JOIN tbl_matriz_ica ON tbl_matriz_ica.codfinca = tbl_fincas.fi_codigo
            WHERE
            tbl_matriz_ica.idlote = tbl_lotes_autorizados.la_idlote AND
            tbl_fincas.fi_estado = 1
           ;';
      $res = mysql_query($qry);

      $item =" ";
      $script ="<script>$(document).ready(function(){";
      while($row_res = mysql_fetch_assoc($res)) {
        //calculamos estado del lote
        $vp=(($row_res["ci_vol_act"]/$row_res["ci_vol_ini"])*100);
        switch ($vp) {
          case ($vp >= 30):
              $class="progress-bar-success";
              $msg_progress = "";
            break;
          case ($vp >= 16 && $vp <= 30):
              $class="progress-bar-warning";
              $msg_progress = "";
            break;
          case ($vp <= 15 ):
              $class="progress-bar-danger";
              $msg_progress = "";
            break;
          case ($vp <= 0 ):
              $class="fade";
              $msg_progress = "Agotado";
            break;
          
          default:
            # code...
            break;
        }
        $fn = 
        $item.='
              <tr>
                <td>'.$row_res["fi_codigo"].'</td>
                <td>'.$row_res["la_idlote"].' - '.$row_res["ano_plant"].'</td>
                <td>'.$msg_progress.'
                  <div class="progress progress-striped active" style="height: 5px;">
                    <div class="progress-bar '.$class.'" style="width: '.$vp.'%;" title="'.$row_res["ci_vol_act"].' m3 ('.$vp.'%)"></div>
                  </div>
                </td>
                <td>
                  <div id="edt-button" onClick="load_modal('.$row_res["fi_id"].', '.$row_res["la_id"].');" class="btn btn-raised btn-primary" title="Lotes Autorizados"><i class="md md-my-location"></i> Rutas </div>
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
                <th>Lote - Año</th>
                <th>% Lote</th>
                <th>Programación</th>
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