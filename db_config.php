<?php

function conectarDB(){
    $servername = "127.0.0.1"; 
    $username = "root"; 
    $password = ""; // Password incorrecto a propósito para probar
    $database = "proyecto_final_web";

    try {
        // Crear la conexión
        $conn = new mysqli($servername, $username, $password, $database);

        // Si la conexión es exitosa, retornar el objeto de conexión
        return $conn;
    } catch (mysqli_sql_exception $e) {
        // Capturar la excepción y retornar el mensaje de error
        return "Error de conexión: " . $e->getMessage();
    }
}
?>
    