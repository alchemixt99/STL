<?php
session_start();
session_unset(); //borro todas las variables de session 
session_destroy();//destruyo la sesion 

include("../mods/route.php");
$e = new route;

$response = new StdClass;
$response->res = true;
$response->mes = $e->path("login");
echo json_encode($response);
?> 