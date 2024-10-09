<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST" || $_SERVER["REQUEST_METHOD"] == "GET") {
        // Capturar las variables enviadas por POST o GET
        $usuario = $_REQUEST["usuario"];
        $clave = $_REQUEST["clave"];
    }

    include('db_config.php');
    $conn = conectarDB();
    if (is_string($conn)) {
        echo $conn; 
    } else {

        // Definir la consulta
        $sql = "SELECT id_usuario, nombre, usuario, correo FROM usuarios where usuario='$usuario' and clave='$clave'";
        //echo $sql;  //probar estructura de la consulta
        // Ejecutar la consulta
        $result = $conn->query($sql);

        // Ver resultados obtenidos
        if ($result->num_rows > 0) {
            echo 1;
        } else {
            echo 0;
        }
        // Cerrar la conexión
        $conn->close();
    }
?>
