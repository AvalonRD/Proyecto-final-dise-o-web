<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar las variables enviadas por POST
    $usuario = $_POST["usuario"];
    $clave = $_POST["clave"];

    include('db_config.php');
    $conn = conectarDB();

    if (is_string($conn)) {
        echo $conn; 
    } else {
        // Definir la consulta utilizando declaraciones preparadas
        $stmt = $conn->prepare("SELECT id_usuario, nombre, usuario, correo FROM usuarios WHERE usuario = ? AND clave = ?");
        $stmt->bind_param("ss", $usuario, $clave); // 'ss' indica que ambos parámetros son cadenas

        // Ejecutar la consulta
        $stmt->execute();
        $result = $stmt->get_result();

        // Ver resultados obtenidos
        if ($result->num_rows > 0) {
            echo 1; // Usuario válido
        } else {
            echo 0; // Datos incorrectos
        }

        // Cerrar la declaración y la conexión
        $stmt->close();
        $conn->close();
    }
}
?>
