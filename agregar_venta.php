<?php
session_start();
include('db_config.php'); // Asegúrate de que este archivo existe y conecta correctamente
$conn = conectarDB();

if (is_string($conn)) {
    die("Error de conexión: " . $conn);
}

// Verificar si el cliente está autenticado
if (!isset($_SESSION['clt_id'])) {
    header("Location: login.html"); // Redirigir al login si no está autenticado
    exit;
}

// Verificar que se reciban los parámetros necesarios
if (isset($_GET['id_producto']) && isset($_GET['precio'])) {
    $id_producto = intval($_GET['id_producto']);
    $precio = floatval($_GET['precio']);
    
    // Verificar que el producto exista en la base de datos
    $query = "SELECT * FROM product WHERE product_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Lógica de la venta
        $row = $result->fetch_assoc();
        $inventario_actual = $row['inventory'];
        $nuevo_inventario = $inventario_actual - 1;

        if ($nuevo_inventario >= 0) {
            // Actualizar el inventario
            $update_query = "UPDATE product SET inventory = ? WHERE product_id = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("ii", $nuevo_inventario, $id_producto);
            
            if ($update_stmt->execute()) {
                // Registrar la compra en la tabla 'purchase'
                $purchase_query = "INSERT INTO purchase (clt_id, purchase_date, total) VALUES (?, NOW(), ?)";
                $purchase_stmt = $conn->prepare($purchase_query);
                $total = $precio; // Total de la compra
                $clt_id = $_SESSION['clt_id']; // Obtener el ID del cliente de la sesión
                $purchase_stmt->bind_param("id", $clt_id, $total);

                if ($purchase_stmt->execute()) {
                    $purchase_id = $purchase_stmt->insert_id; // Obtener el ID de la compra

                    // Registrar el detalle de la compra
                    $venta_query = "INSERT INTO purchase_detail (purchase_id, product_id, quantity) VALUES (?, ?, ?)";
                    $venta_stmt = $conn->prepare($venta_query);
                    $quantity = 1; // Cantidad vendida 
                    $venta_stmt->bind_param("iii", $purchase_id, $id_producto, $quantity);

                    if ($venta_stmt->execute()) {
                        // Redirigir a una página de confirmación de compra
                        header("Location: gracias_por_su_compra.php");
                        exit;
                    } else {
                        echo "Error al registrar el detalle de la compra.";
                    }
                } else {
                    echo "Error al registrar la compra.";
                }
            } else {
                echo "Error al actualizar el inventario.";
            }
        } else {
            // No hay inventario
            header("Location: error_inventario.php");
            exit;
        }
    } else {
        // Producto no encontrado
        header("Location: error_producto_no_encontrado.php"); // página de error
        exit;
    }
} else {
    echo "Parámetros inválidos.";
}

$conn->close();
?>
