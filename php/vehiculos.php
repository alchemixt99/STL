<?php
require_once("funciones.php");
require_once("messages.php");
class vehiculos{

  function get_vehiculos(){
    $con = new con();
    $msg = new messages();
    $rt = new route();

    $con->connect();

    //consultamos usuarios
    if(isset($_SESSION["ses_id"])){
      $qry='SELECT * FROM tbl_vehiculos AS V
            INNER JOIN tbl_personas AS P ON P.pe_ve_id = V.ve_id
            WHERE V.ve_estado=1;';
      //echo $qry;
      $res = mysql_query($qry);

      $item =" ";
      $script ="<script>$(document).ready(function(){";
      while($row_res = mysql_fetch_assoc($res)) {
        $item.='
              <tr>
                <td>'.$row_res["ve_placa"].'</td>
                <td>'.$row_res["pe_nombre"].'</td>
                <td>'.$row_res["ve_timestamp"].'</td>
                <td>
                  <div id="del-button" onClick="borrar_usuario('.$row_res["ve_id"].', this)" class="btn btn-floating-mini btn-danger" title="Borrar"><i class="md md-delete"></i> </div>
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
                <th>Placa</th>
                <th>Propietario</th>
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
  function get_options_propietarios(){
    $con = new con();
    $msg = new messages();
    $rt = new route();

    $con->connect();


    //consultamos fincas desde la matriz ica
    if(isset($_SESSION["ses_id"])){
      $qry='SELECT DISTINCT pe_id, pe_nombre, pe_cedula FROM tbl_personas WHERE pe_tipo=1 OR pe_tipo=3 ORDER BY pe_nombre ASC';
      $res = mysql_query($qry);

      $item =" ";
      $script ="<script>$(document).ready(function(){";
      while($row_res = mysql_fetch_assoc($res)) {
        $item.='
              <option value="'.$row_res["pe_id"].'">'.$row_res["pe_nombre"].' ('.$row_res["pe_cedula"].')</option>
        ';
        $script.='';
      }
      $script.='});</script>';
    }
    else{$rt->routing($rt->path("login"));}

    $html='
        <select class="form-control valued" id="cod_prop">
          '.$item.'
        </select>
    ';
    $con->disconnect();
    return $script.$html;
  }
  function get_options_vehiculos(){
    $con = new con();
    $msg = new messages();
    $rt = new route();

    $con->connect();


    //consultamos fincas desde la matriz ica
    if(isset($_SESSION["ses_id"])){
      $qry='SELECT DISTINCT ve_id, ve_placa, ve_capacidad_m3 FROM tbl_vehiculos WHERE ve_estado=1 ORDER BY ve_placa ASC';
      $res = mysql_query($qry);

      $item =" ";
      $script ="<script>$(document).ready(function(){";
      while($row_res = mysql_fetch_assoc($res)) {
        $item.='
              <option value="'.$row_res["ve_id"].'">'.$row_res["ve_placa"].' (Capacidad: '.$row_res["ve_capacidad_m3"].' m<sup>3</sup>)</option>
        ';
        $script.='';
      }
      $script.='});</script>';
    }
    else{$rt->routing($rt->path("login"));}

    $html='
        <select class="form-control valued" id="cod_prop">
          '.$item.'
        </select>
    ';
    $con->disconnect();
    return $script.$html;
  }
}
?>