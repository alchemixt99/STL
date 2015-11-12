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
      $qry='SELECT * FROM tbl_remisiones_fisicas ORDER BY rf_estado DESC ';
      $res = mysql_query($qry);

      $item =" ";
      $script ="<script>$(document).ready(function(){";
      while($row_res = mysql_fetch_assoc($res)) {
        //calculamos porcentaje de uso
          $porcentaje=(($row_res["rf_cant_usados"]*100)/($row_res["rf_dig_fin"]-$row_res["rf_dig_ini"]));
        //boton de activacion/desactivación
          if ($row_res["rf_estado"]==1) {
            $btn = '<div id="act-button" style="display:" onclick="change(1, '.$row_res['rf_id'].')" class="btn btn-floating-mini btn-success" title="Activar Paquete"><i class="md  md-done"></i></div>
                  <div id="des-button" style="display:none" onclick="change(2, '.$row_res['rf_id'].')" class="btn btn-floating-mini btn-warning" title="Desactivar Paquete"><i class="md  md-close"></i></div>';
          }else{
            $btn = '<div id="act-button" style="display:none" onclick="change(1, '.$row_res['rf_id'].')" class="btn btn-floating-mini btn-success" title="Activar Paquete"><i class="md  md-done"></i></div>
                  <div id="des-button" style="display:" onclick="change(2, '.$row_res['rf_id'].')" class="btn btn-floating-mini btn-warning" title="Desactivar Paquete"><i class="md  md-close"></i></div>';
          }
          $btn_del = '<div id="act-button" onclick="change(99, '.$row_res['rf_id'].')" class="btn btn-floating-mini btn-danger" title="Borrar Paquete"><i class="md  md-delete"></i></div>';
        //--

        $item.='
              <tr>
                <td>'.$row_res["rf_timestamp"].'</td>
                <td>'.$row_res["rf_persona_entrega"].'</td>
                <td>'.$row_res["rf_interventor"].'</td>
                <td>'.$row_res["rf_dig_ini"].'</td>
                <td>'.$row_res["rf_dig_fin"].'</td>
                <td><div class="progress progress-striped active">
                      <div class="progress-bar" title="'.$row_res["rf_cant_usados"].'  ('.$porcentaje.'%)" style="width: '.$porcentaje.'%; height:10px;"></div>
                    </div>
                </td>
                <td>
                '.$btn.'
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
                <th>Recibido</th>
                <th>Interventor</th>
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