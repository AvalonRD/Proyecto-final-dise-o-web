<?php
    include('db_config.php');

    // Conectar a la base de datos
    $conn = conectarDB();

    // Verificar si la conexión fue exitosa
    if (is_string($conn)) {
        echo $conn; // Muestra el error si es un string
    } else {
        echo "Conexión exitosa a la base de datos.";
    }
?>
