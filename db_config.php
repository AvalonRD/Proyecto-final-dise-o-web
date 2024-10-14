<?php

// Función para conectar a la base de datos
function conectarDB() {
    $servername = "127.0.0.1"; 
    $username = "root"; 
    $password = ""; // Ajusta este valor si tienes un password en tu base de datos
    $database = "proyecto_final_web";

    // Crear la conexión
    $conn = new mysqli($servername, $username, $password, $database);

    // Verificar si hay errores en la conexión
    if ($conn->connect_error) {
        return "Error de conexión: " . $conn->connect_error;
    }

    // Retornar la conexión si es exitosa
    return $conn;
}
?>
