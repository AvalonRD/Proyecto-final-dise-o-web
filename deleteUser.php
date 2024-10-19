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

    // Validar que id_usuario no esté vacío, sea un número y positivo
    if (empty($id_usuario) || !is_numeric($id_usuario) || (int)$id_usuario <= 0) {
        echo json_encode(['error' => 'ID de usuario inválido.']);
        exit;
    }

    // Usar una declaración preparada para eliminar el usuario
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
    $stmt->bind_param("i", $id_usuario); // 'i' indica que es un entero

    // Ejecutar la consulta y verificar si se eliminó correctamente
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true]);  // Enviar mensaje de éxito
        } else {
            echo json_encode(['error' => 'No se encontró el usuario o no se pudo eliminar.']);
        }
    } else {
        echo json_encode(['error' => 'Error al eliminar el usuario.']);
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
}
?>
