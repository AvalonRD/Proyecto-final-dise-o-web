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
        // Recuperar el registro del usuario
        $sql = "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $usuario_data = $result->fetch_assoc(); // Obtener los datos del usuario
            echo json_encode($usuario_data); // Devolver los datos en formato JSON
        } else {
            echo json_encode(['error' => 'Usuario no encontrado']);
        }
        $conn->close();
    }
   
?>
