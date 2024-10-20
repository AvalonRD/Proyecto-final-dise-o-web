<?php
session_start();
include('db_config.php');
$conn = conectarDB();

if (is_string($conn)) {
    die("Error de conexión: " . $conn);
}

// Verifica si hay productos en el carrito
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo "El carrito está vacío.";
    exit;
}

// Verifica si el cliente está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html"); // Redirigir al login si no está autenticado
    exit;
}

// Inicia la transacción
$conn->begin_transaction();

try {
    // Inserta la compra
    $total = 0;
    $query = "INSERT INTO purchase (clt_id, purchase_date, total) VALUES (?, NOW(), ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("id", $_SESSION['user_id'], $total);
    $stmt->execute();
    $purchase_id = $conn->insert_id; // Obtiene el ID de la compra

    // Inserta los detalles de la compra
    foreach ($_SESSION['carrito'] as $id_producto => $cantidad) {
        // Obtener el precio del producto
        $query = "SELECT price FROM product WHERE product_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_producto);
        $stmt->execute();
        $result = $stmt->get_result();
        $producto = $result->fetch_assoc();

        // Calcula el total
        $precio_total = $producto['price'] * $cantidad;
        $total += $precio_total;

        // Inserta el detalle de la compra
        $query = "INSERT INTO purchase_detail (purchase_id, product_id, quantity) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iii", $purchase_id, $id_producto, $cantidad);
        $stmt->execute();
    }

    // Actualiza el total de la compra
    $query = "UPDATE purchase SET total = ? WHERE purchase_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("di", $total, $purchase_id);
    $stmt->execute();

    // Finaliza la transacción
    $conn->commit();
    
    // Limpia el carrito
    unset($_SESSION['carrito']);

    echo "Compra realizada exitosamente.";
} catch (Exception $e) {
    // En caso de error, deshace la transacción
    $conn->rollback();
    echo "Error al realizar la compra: " . $e->getMessage();
}

// Cierra la conexión
$conn->close();
?>
