<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST" || $_SERVER["REQUEST_METHOD"] == "GET") {
        // Capturar las variables enviadas por POST o GET
        $id_usuario = $_REQUEST["id_usuario"];
    }

    include('db_config.php');
    $conn = conectarDB();
    if (is_string($conn)) {
        echo $conn; 
    } else {
        // Definir la consulta DELETE sin declaración preparada
        $sql = "DELETE FROM usuarios WHERE id_usuario = $id_usuario";

        // Ejecutar la consulta y verificar si se eliminó correctamente
        if ($conn->query($sql) === TRUE) {
            echo 'success';  // Enviar mensaje de éxito
        } else {
            echo 'error';  // Enviar mensaje de error
        }

        // Cerrar la conexión
        $conn->close();
    }
?>
