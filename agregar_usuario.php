<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar las variables enviadas por POST
    $usuario = $_POST['usuario'] ?? '';
    $clave = $_POST['clave'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';

    // Validar y sanitizar entradas
    $usuario = filter_var($usuario, FILTER_SANITIZE_STRING);
    $clave = filter_var($clave, FILTER_SANITIZE_STRING);
    $nombre = filter_var($nombre, FILTER_SANITIZE_STRING);
    $correo = filter_var($correo, FILTER_SANITIZE_EMAIL);

    // Verificar que los campos requeridos no estén vacíos
    if (empty($usuario) || empty($clave) || empty($nombre) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        echo 'error'; // Respuesta de error
        exit;
    }

    include('db_config.php');
    $conn = conectarDB();

    if (is_string($conn)) {
        echo $conn; 
        exit;
    }

    // Preparar la consulta sin hashear la contraseña
    $stmt = $conn->prepare("INSERT INTO usuario (nombre_user, username, passwd, email) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $usuario, $clave, $correo); // Almacena la contraseña en texto plano

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo 'success'; // Enviar respuesta de éxito a AJAX
    } else {
        echo 'error'; // Enviar respuesta de error a AJAX
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
}
?>
