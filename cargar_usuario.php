<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Capturar el ID de usuario
    $id_usuario = isset($_GET['id_usuario']) ? $_GET['id_usuario'] : '';

    include('db_config.php');
    $conn = conectarDB();

    if (is_string($conn)) {
        echo json_encode(['error' => 'No se pudo conectar a la base de datos.']);
        exit;
    }

    // Verificar que el ID no esté vacío y sea numérico
    if (empty($id_usuario) || !is_numeric($id_usuario)) {
        echo json_encode(['error' => 'ID de usuario inválido']);
        exit;
    }

    // Consultar el usuario
    $stmt = $conn->prepare("SELECT * FROM usuario WHERE user_id = ?");
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario_data = $result->fetch_assoc();
        echo json_encode($usuario_data);
    } else {
        echo json_encode(['error' => 'Usuario no encontrado']);
    }

    $stmt->close();
    $conn->close();
}
?>
