<?php
session_start(); // Iniciar la sesión
include('db_config.php');
$conn = conectarDB();

if (is_string($conn)) {
    echo json_encode(['error' => 'No se pudo conectar a la base de datos.']);
    exit;
}

// Verificar que la solicitud sea POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar los datos del formulario
    $nombre = htmlspecialchars($_POST['nombre'], ENT_QUOTES, 'UTF-8');
    $usuario = htmlspecialchars($_POST['usuario'], ENT_QUOTES, 'UTF-8');
    $clave = htmlspecialchars($_POST['clave'], ENT_QUOTES, 'UTF-8');
    $correo = htmlspecialchars($_POST['correo'], ENT_QUOTES, 'UTF-8');
    $telefono = htmlspecialchars($_POST['telefono'], ENT_QUOTES, 'UTF-8'); // Campo de teléfono
    $direccion = htmlspecialchars($_POST['direccion'], ENT_QUOTES, 'UTF-8'); // Campo de dirección

    // Verificar que los campos no estén vacíos
    if (empty($nombre) || empty($usuario) || empty($clave) || empty($correo) || empty($direccion)) {
        echo json_encode(['error' => 'Todos los campos son requeridos.']);
        exit;
    }

    // Preparar la consulta para insertar el nuevo cliente
    $stmt = $conn->prepare("INSERT INTO client (name_clt, username, passwd_clt, email_clt, phone_clt, address_clt) VALUES (?, ?, ?, ?, ?, ?)");

    // Asignar los parámetros
    $stmt->bind_param("ssssss", $nombre, $usuario, $clave, $correo, $telefono, $direccion);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redirigir a la página inicial después del registro exitoso
        header("Location: index.html");
        exit(); // Asegúrate de salir después de la redirección
    } else {
        echo json_encode(['error' => 'Error al registrar el cliente.']);
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
}
?>
