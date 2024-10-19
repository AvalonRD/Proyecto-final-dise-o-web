<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Capturar el ID de cliente
    $id_cliente = isset($_GET['id_usuario']) ? $_GET['id_usuario'] : '';

    include('db_config.php');
    $conn = conectarDB();

    if (is_string($conn)) {
        echo json_encode(['error' => 'No se pudo conectar a la base de datos.']);
        exit;
    }

    // Verificar que el ID no esté vacío y sea numérico
    if (empty($id_cliente) || !is_numeric($id_cliente)) {
        echo json_encode(['error' => 'ID de cliente inválido']);
        exit;
    }

    // Consultar el cliente
    $stmt = $conn->prepare("SELECT * FROM client WHERE clt_id = ?");
    $stmt->bind_param("i", $id_cliente);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $cliente_data = $result->fetch_assoc();
        echo json_encode($cliente_data);
    } else {
        echo json_encode(['error' => 'Cliente no encontrado']);
    }

    $stmt->close();
    $conn->close();
}
?>
