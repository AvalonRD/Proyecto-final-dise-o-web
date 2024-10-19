<?php
function conectarDB() {
    // Parámetros de conexión
    $servidor = "localhost"; // Cambia esto si es necesario
    $usuario = "tu_usuario"; // Cambia esto por tu usuario de MySQL
    $contraseña = "tu_contraseña"; // Cambia esto por tu contraseña de MySQL
    $base_de_datos = "tu_base_de_datos"; // Cambia esto por el nombre de tu base de datos

    // Crear conexión
    $conn = new mysqli($servidor, $usuario, $contraseña, $base_de_datos);

    // Verificar conexión
    if ($conn->connect_error) {
        return "Error de conexión: " . $conn->connect_error;
    }

    return $conn; // Retornar la conexión si es exitosa
}
?>
