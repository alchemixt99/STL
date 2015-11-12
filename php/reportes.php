<?php
require_once("funciones.php");
require_once("messages.php");
  
  $con = new con();
  $msg = new messages();
  $fun = new funciones();

  $con->connect();

  //traemos opción
  $id=$_GET["i"];

  $html='';

  switch ($id) {
    case 1:
       $qry='SELECT * FROM tbl_despachos';
       $cabecera_tabla='
          <td>Consecutivo</td>
          <td>Fecha</td>
          <td>Observacion</td>
          <td>Estado</td>';
    break;
    case 2:
       $qry='
          SELECT * FROM `tbl_despachos`
          INNER JOIN tbl_personas ON pe_id = de_pe_id
          INNER JOIN tbl_vehiculos ON ve_id = pe_ve_id
          INNER JOIN tbl_turnos ON tu_id = de_tu_id
          INNER JOIN tbl_inventario ON in_id = de_in_id
          INNER JOIN tbl_fincas ON fi_id=in_fi_id
          INNER JOIN tbl_supervisores ON su_id = in_supervisor
          INNER JOIN tbl_subnucleos ON sn_id = fi_sn_id
          INNER JOIN tbl_lotes_autorizados ON la_id = in_lote
          INNER JOIN tbl_matriz_ica ON codfinca = fi_codigo
          WHERE 
          idlote = la_idlote
          AND de_estado = 2';
       $cabecera_tabla='
          <td>Cons. ICA</td>
          <td>Cons. Sistema</td>
          <td>Conductor</td>
          <td>cedula</td>
          <td>Vehiculo</td>
          <td>Fecha Salida</td>
          <td>Estado</td>';
    break;
    case 3:
       $qry='
          SELECT * FROM `tbl_despachos`
          INNER JOIN tbl_personas ON pe_id = de_pe_id
          INNER JOIN tbl_vehiculos ON ve_id = pe_ve_id
          INNER JOIN tbl_turnos ON tu_id = de_tu_id
          INNER JOIN tbl_inventario ON in_id = de_in_id
          INNER JOIN tbl_fincas ON fi_id=in_fi_id
          INNER JOIN tbl_supervisores ON su_id = in_supervisor
          INNER JOIN tbl_subnucleos ON sn_id = fi_sn_id
          INNER JOIN tbl_lotes_autorizados ON la_id = in_lote
          INNER JOIN tbl_matriz_ica ON codfinca = fi_codigo
          WHERE 
          idlote = la_idlote
          AND de_estado = 2';
       $cabecera_tabla='
          <td>Cons. ICA</td>
          <td>Cons. Sistema</td>
          <td>Conductor</td>
          <td>cedula</td>
          <td>Vehiculo</td>
          <td>Fecha Salida</td>
          <td>Estado</td>';
    break;
  
  }
  $res = $fun->get_array($qry);
  if($res!=false){
    //$fun->print_array($res);
    //formato de tabla
    $html.='
    <script src="../lib/js/jquery.min.js"></script>
    <style>
    .CSSTableGenerator {
      margin:0px;padding:0px;
      width:100%;
      box-shadow: 10px 10px 5px #888888;
      border:1px solid #000000;
      
      -moz-border-radius-bottomleft:0px;
      -webkit-border-bottom-left-radius:0px;
      border-bottom-left-radius:0px;
      
      -moz-border-radius-bottomright:0px;
      -webkit-border-bottom-right-radius:0px;
      border-bottom-right-radius:0px;
      
      -moz-border-radius-topright:0px;
      -webkit-border-top-right-radius:0px;
      border-top-right-radius:0px;
      
      -moz-border-radius-topleft:0px;
      -webkit-border-top-left-radius:0px;
      border-top-left-radius:0px;
    }.CSSTableGenerator table{
        border-collapse: collapse;
            border-spacing: 0;
      width:100%;
      height:100%;
      margin:0px;padding:0px;
    }.CSSTableGenerator tr:last-child td:last-child {
      -moz-border-radius-bottomright:0px;
      -webkit-border-bottom-right-radius:0px;
      border-bottom-right-radius:0px;
    }
    .CSSTableGenerator table tr:first-child td:first-child {
      -moz-border-radius-topleft:0px;
      -webkit-border-top-left-radius:0px;
      border-top-left-radius:0px;
    }
    .CSSTableGenerator table tr:first-child td:last-child {
      -moz-border-radius-topright:0px;
      -webkit-border-top-right-radius:0px;
      border-top-right-radius:0px;
    }.CSSTableGenerator tr:last-child td:first-child{
      -moz-border-radius-bottomleft:0px;
      -webkit-border-bottom-left-radius:0px;
      border-bottom-left-radius:0px;
    }.CSSTableGenerator tr:hover td{
      
    }
    .CSSTableGenerator tr:nth-child(odd){ background-color:#b2b2b2; }
    .CSSTableGenerator tr:nth-child(even)    { background-color:#ffffff; }.CSSTableGenerator td{
      vertical-align:middle;
      
      
      border:1px solid #000000;
      border-width:0px 1px 1px 0px;
      text-align:left;
      padding:7px;
      font-size:10px;
      font-family:Helvetica;
      font-weight:normal;
      color:#000000;
    }.CSSTableGenerator tr:last-child td{
      border-width:0px 1px 0px 0px;
    }.CSSTableGenerator tr td:last-child{
      border-width:0px 0px 1px 0px;
    }.CSSTableGenerator tr:last-child td:last-child{
      border-width:0px 0px 0px 0px;
    }
    .CSSTableGenerator tr:first-child td{
        background:-o-linear-gradient(bottom, #b2b2b2 5%, #003f7f 100%);  background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #b2b2b2), color-stop(1, #003f7f) );
      background:-moz-linear-gradient( center top, #b2b2b2 5%, #003f7f 100% );
      filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#b2b2b2", endColorstr="#003f7f");  background: -o-linear-gradient(top,#b2b2b2,003f7f);

      background-color:#b2b2b2;
      border:0px solid #000000;
      text-align:center;
      border-width:0px 0px 1px 1px;
      font-size:12px;
      font-family:Helvetica;
      font-weight:bold;
      color:#ffffff;
    }
    .CSSTableGenerator tr:first-child:hover td{
      background:-o-linear-gradient(bottom, #b2b2b2 5%, #003f7f 100%);  background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #b2b2b2), color-stop(1, #003f7f) );
      background:-moz-linear-gradient( center top, #b2b2b2 5%, #003f7f 100% );
      filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#b2b2b2", endColorstr="#003f7f");  background: -o-linear-gradient(top,#b2b2b2,003f7f);

      background-color:#b2b2b2;
    }
    .CSSTableGenerator tr:first-child td:first-child{
      border-width:0px 0px 1px 0px;
    }
    .CSSTableGenerator tr:first-child td:last-child{
      border-width:0px 0px 1px 1px;
    }
    </style>
    <div id="report_box">
      <table class="CSSTableGenerator">
        <tr>
          '.$cabecera_tabla.'
        </tr>';
    for ($i=0; $i < count($res); $i++) { 
      switch ($id) {
        case 1:
            if($res[$i]['de_ica_observacion']==""){$obs="sin Observacionrvaciones registradas.";}else{$obs=$res[$i]['de_ica_observacion'];}
            if($res[$i]['de_estado']==2){$estado = "Generado y asignado correctamente.";}else{$estado="Revisar observaciones.";}
            $html.='<tr>
                      <td>'.$res[$i]['de_ica'].'</td>
                      <td>'.$res[$i]['de_timestamp'].'</td>
                      <td>'.$obs.'</td>
                      <td>'.$estado.'</td>
                    </tr>';
        break;
        case 2:
            //fecha de salida
            $fecha = split(" ", $res[$i]['de_timestamp']);
            list($año, $mes, $dia) = split('[/.-]', $fecha[0]);
            if($res[$i]['de_estado']==2){$estado = "Generado y asignado correctamente.";}else{$estado="Revisar observaciones.";}
            $html.='<tr>
                      <td>'.$res[$i]['de_ica'].'</td>
                      <td>'.$res[$i]['de_sistema'].'</td>
                      <td>'.$res[$i]['pe_nombre'].'</td>
                      <td>'.$res[$i]['pe_cedula'].'</td>
                      <td>'.$res[$i]['ve_placa'].'</td>
                      <td>'.($dia+1).'-'.$mes.'-'.$año.'</td>
                      <td>'.$estado.'</td>
                    </tr>';
        break;
        case 3:
            //fecha de salida
            $fecha = split(" ", $res[$i]['de_timestamp']);
            list($año, $mes, $dia) = split('[/.-]', $fecha[0]);
            if($res[$i]['de_estado']==2){$estado = "Generado y asignado correctamente.";}else{$estado="Revisar observaciones.";}
            $html.='<tr>
                      <td>'.$res[$i]['de_ica'].'</td>
                      <td>'.$res[$i]['de_sistema'].'</td>
                      <td>'.$res[$i]['pe_nombre'].'</td>
                      <td>'.$res[$i]['pe_cedula'].'</td>
                      <td>'.$res[$i]['ve_placa'].'</td>
                      <td>'.($dia+1).'-'.$mes.'-'.$año.'</td>
                      <td></td>
                      <td></td>
                      <td>'.$estado.'</td>
                    </tr>';
        break;
      }
      
    }
    $html.='    
      </table>
    </div>
    <div style="margin-top:30px;">
      <a href="#" onclick="desc(3)">Excel</a>
    </div>
    <script type="text/javascript">
      /* descarga de reporte */
        function desc(tipo){
          var cont = $("#report_box").html();
          console.log(cont);
          $.ajax({      
            url: "ajax_ica.php",     
            dataType: "json",     
              type: "POST",     
              data: { 
                      action: "send_report",
                      o: "ICA_Generados",
                      c: cont,
                      t: tipo
                    },
            success: function(data){    
              var url = "../php/exportar.php";
              window.open(url, "_blank");
            }
          });
        }
    </script>
    ';
  }

  echo $html; 
  $con->disconnect();

?>