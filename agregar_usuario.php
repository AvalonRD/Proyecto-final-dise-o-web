<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar las variables enviadas por POST
    $usuario = $_POST['usuario'] ?? '';
    $clave = $_POST['clave'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $direccion = $_POST['direccion'] ?? '';

    // Validar y sanitizar entradas
    $usuario = filter_var($usuario, FILTER_SANITIZE_STRING);
    $clave = password_hash($clave, PASSWORD_BCRYPT); // Hashear la contraseña
    $nombre = filter_var($nombre, FILTER_SANITIZE_STRING);
    $correo = filter_var($correo, FILTER_SANITIZE_EMAIL);
    $telefono = filter_var($telefono, FILTER_SANITIZE_STRING);
    $direccion = filter_var($direccion, FILTER_SANITIZE_STRING);

    // Verificar que los campos requeridos no estén vacíos y que el correo sea válido
    if (empty($usuario) || empty($clave) || empty($nombre) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        echo 'error'; // Respuesta de error
        exit;
    }

    // Conectar a la base de datos
    include('db_config.php');
    $conn = conectarDB();

    // Verificar si hubo un error al conectar
    if (is_string($conn)) {
        echo $conn; // Mensaje de error de conexión
        exit;
    }

    // Preparar la consulta para insertar el usuario
    $stmt = $conn->prepare("INSERT INTO client (name_clt, username, passwd_clt, email_clt, phone_clt, address_clt) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nombre, $usuario, $clave, $correo, $telefono, $direccion);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo 'success'; // Enviar respuesta de éxito a AJAX
    } else {
        // Proporcionar más información en caso de error
        error_log($stmt->error); // Registro del error en el log del servidor
        echo 'error'; // Enviar respuesta de error a AJAX
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
}
?>
