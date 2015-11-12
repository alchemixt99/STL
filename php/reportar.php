<?php
require_once("funciones.php");
require_once("messages.php");
class reportar{

  function get_reports(){
    $con = new con();
    $msg = new messages();
    $rt = new route();

    $con->connect();


    //consultamos fincas
    if(isset($_SESSION["ses_id"])){
      $qry='SELECT * FROM tbl_reporte_consecutivo ORDER BY rp_consecutivo DESC ';
      $res = mysql_query($qry);

      $item =" ";
      $script ="<script>$(document).ready(function(){";
      while($row_res = mysql_fetch_assoc($res)) {

        $item.='
              <tr>
                <td>'.$row_res["rp_timestamp"].'</td>
                <td>'.$row_res["rp_consecutivo"].'</td>
                <td>'.$row_res["rp_causa"].'</td>
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
                <th>Fecha reporte</th>
                <th>Consecutivo</th>
                <th>Causa</th>
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