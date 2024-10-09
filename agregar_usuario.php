<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST" || $_SERVER["REQUEST_METHOD"] == "GET") {
        // Capturar las variables enviadas por POST o GET
        $usuario = $_POST['usuario'];
        $clave = $_POST['clave'];
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
    }

    include('db_config.php');
    $conn = conectarDB();

    if (is_string($conn)) {
        echo $conn; 
    } else {
        $sql = "INSERT INTO usuarios (usuario, clave, nombre, correo) VALUES ('$usuario', '$clave', '$nombre', '$correo')";
        // Ejecutar la consulta
        if ($conn->query($sql) === TRUE) {
            echo 'success'; // Enviar respuesta de éxito a AJAX
        } else {
            echo 'error'; // Enviar respuesta de error a AJAX
        }
    // Cerrar la conexión
    $conn->close();
    }
    

?>
