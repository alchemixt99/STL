<?php
session_start();
require("funciones.php");
require("messages.php");

    $fun = new funciones();
    $msg = new messages();

    /*css*/
    //definimos css
        $css = '
        <style>
        table, th, td {
           border: 1px solid black;
        }
        </style>';


    /*recibimos variables*/
    $o = $_SESSION['report']['o'];
    $c = $_SESSION['report']['c'];
    $t = $_SESSION['report']['t'];
    $n = $_SESSION['report']['n'];

    $cont = $css.$c;

    //$fun->create_report($c,$n,$t);
    require_once '../lib/dompdf/dompdf_config.inc.php';
    $dompdf = new DOMPDF();
    $dompdf->load_html($cont);
    $dompdf->render();
    switch ($t) {
        case 1: 
            $tipo="pdf";     
            $ext = ".pdf"; 
            $dompdf->stream($n.$ext);
        break;
        case 2: $tipo="excel";   $ext = ".doc"; break;
        case 3: $tipo="word";    $ext = ".xls"; break;
    }
    if($t!=1){
        header("Content-type: application/vnd.ms-".$tipo);
        header("Content-Disposition: attachment; filename=".$n.$ext);
        header("Pragma: no-cache");
        header("Expires: 0");    
        echo $cont;
    }
?>
