<?php
session_start();
require("funciones.php");
require("messages.php");

    $fun = new funciones();
    $msg = new messages();

    /*recibimos variables*/
    $o = $_POST['o'];
    $c = $_POST['c'];
    $t = $_POST['t'];
    $n = $o."_".date('YmdGis');

    //$fun->create_report($c,$n,$t);
    require_once '../lib/dompdf/dompdf_config.inc.php';
    $dompdf = new DOMPDF();
    $dompdf->load_html($c);
    $dompdf->render();
    switch ($t) {
        case 1: $ext = ".pdf"; break;
        case 2: $ext = ".doc"; break;
        case 3: $ext = ".xls"; break;
    }
    echo $n.$ext;
    $dompdf->stream($n.$ext);

    header("Content-type: application/vnd.ms-$tipo");
    header("Content-Disposition: attachment; filename=mi_archivo$extension");
    header("Pragma: no-cache");
    header("Expires: 0");    
}