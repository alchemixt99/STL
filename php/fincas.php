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
      $qry='SELECT * FROM tbl_fincas 
            INNER JOIN tbl_subnucleos ON sn_id = fi_sn_id
            WHERE fi_estado=1 ORDER BY fi_codigo ASC ';
      $res = mysql_query($qry);

      $item =" ";
      $script ="<script>$(document).ready(function(){";
      while($row_res = mysql_fetch_assoc($res)) {
        $item.='
              <tr>
                <td>'.$row_res["fi_codigo"].'</td>
                <td>'.$row_res["sn_subnucleo"].'</td>
                <td>'.$row_res["fi_timestamp"].'</td>
                <td>
                  <div id="del-button" onclick="borrar_finca('.$row_res["fi_id"].', this)" class="btn btn-floating-mini btn-danger" title="Borrar"><i class="md  md-delete"></i></div>
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
                <th>Subnucleo</th>
                <th>Fecha Autorización</th>
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
  function get_options_fincas($select_id=null, $get_id=null){
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
        $qry_fin='SELECT * FROM tbl_fincas WHERE fi_codigo="'.$row_res['codfinca'].'" AND fi_estado<99;';
        $res_fin = mysql_query($qry_fin);
        $cant_fin = mysql_num_rows($res_fin);
        //echo "<br>".$qry_aut."<br> resultados: ".$cant_aut;
        if($cant_fin>0){
          $display = "style='display:none;'";
        }else{
          $display = "";
        }
        $item.='
              <option '.$display.' value="'.$row_res["codfinca"].'">'.$row_res["codfinca"].' ('.$row_res["municipio"].' - '.$row_res["depto"].')</option>
        ';
        $script.='';
      }
      $script.='});</script>';
    }
    else{$rt->routing($rt->path("login"));}

    if($select_id!=null){
      $id = 'id="'.$select_id.'"';
    }else{
      $id = 'id="cod"';
    }

    $html='
        <select class="form-control valued" '.$id.'>
          '.$item.'
        </select>
    ';
    $con->disconnect();
    return $script.$html;
  }
  function get_options_fincas_aut($select_id=null, $get_id=false){
    $con = new con();
    $msg = new messages();
    $rt = new route();

    $con->connect();


    //consultamos fincas desde la matriz ica
    if(isset($_SESSION["ses_id"])){
      $qry='SELECT DISTINCT fi_id, codfinca, municipio, depto FROM tbl_matriz_ica 
      INNER JOIN tbl_fincas ON fi_codigo = codfinca
      WHERE fi_estado<99
      ORDER BY codfinca ASC';
      $res = mysql_query($qry);

      $item =" ";
      $script ="<script>$(document).ready(function(){";
      while($row_res = mysql_fetch_assoc($res)) {
        if($get_id){
          $item.='
                <option value="'.$row_res["fi_id"].'">'.$row_res["codfinca"].' ('.$row_res["municipio"].' - '.$row_res["depto"].')</option>
          ';
        }else{
          $item.='
                <option value="'.$row_res["codfinca"].'">'.$row_res["codfinca"].' ('.$row_res["municipio"].' - '.$row_res["depto"].')</option>
          ';          
        }
        $script.='';
      }
      $script.='});</script>';
    }
    else{$rt->routing($rt->path("login"));}

    if($select_id!=null){
      $id = 'id="'.$select_id.'"';
    }else{
      $id = 'id="cod"';
    }

    $html='
        <select class="form-control valued" '.$id.'>
          '.$item.'
        </select>
    ';
    $con->disconnect();
    return $script.$html;
  }
}
?>