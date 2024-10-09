<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" || $_SERVER["REQUEST_METHOD"] == "GET") {
    // Capturar las variables enviadas por POST o GET
    $usuario = $_REQUEST["usuario"];
    $clave = $_REQUEST["clave"];

}

include('funciones_administradores.php');
cargar_base();
$conn=cargar_base();

$sql="INSERT INTO administradores (usuario,clave) values ('$usuario','$clave');";
$result = mysqli_query($conn, $sql);
header("Location: index.php"); 
    
?>