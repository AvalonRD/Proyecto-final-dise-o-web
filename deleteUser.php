<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar la variable id_usuario enviada por POST
    $id_usuario = isset($_POST['id_usuario']) ? $_POST['id_usuario'] : '';

    include('db_config.php');
    $conn = conectarDB();

    if (is_string($conn)) {
        echo json_encode(['error' => 'No se pudo conectar a la base de datos.']);
        exit;
    }

    // Validar que id_usuario no esté vacío y sea un número
    if (empty($id_usuario) || !is_numeric($id_usuario)) {
        echo json_encode(['error' => 'ID de usuario inválido.']);
        exit;
    }

    // Usar una declaración preparada para eliminar el usuario
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
    $stmt->bind_param("i", $id_usuario); // 'i' indica que es un entero

    // Ejecutar la consulta y verificar si se eliminó correctamente
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);  // Enviar mensaje de éxito
    } else {
        echo json_encode(['error' => 'Error al eliminar el usuario: ' . $stmt->error]);
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
}
?>
