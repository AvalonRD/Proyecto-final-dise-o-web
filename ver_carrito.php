<?php
session_start();

// Asegúrate de que el carrito esté inicializado
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Calcular el total
$total = 0;
?>

<table>
    <tr>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Precio</th>
        <th>Total</th>
        <th>Acción</th>
    </tr>
    <?php if (empty($_SESSION['carrito'])): ?>
        <tr>
            <td colspan="5">El carrito está vacío.</td>
        </tr>
    <?php else: ?>
        <?php foreach ($_SESSION['carrito'] as $id_producto => $cantidad): ?>
            <?php
            // Consulta para obtener los detalles del producto
            include('db_config.php');
            $conn = conectarDB();
            $query = "SELECT name_pd, price FROM product WHERE product_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $id_producto);
            $stmt->execute();
            $result = $stmt->get_result();
            $producto = $result->fetch_assoc();
            $precio_total = $producto['price'] * $cantidad;
            $total += $precio_total;
            ?>
            <tr>
                <td><?php echo htmlspecialchars($producto['name_pd']); ?></td>
                <td><?php echo htmlspecialchars($cantidad); ?></td>
                <td><?php echo htmlspecialchars($producto['price']); ?></td>
                <td><?php echo htmlspecialchars($precio_total); ?></td>
                <td><a href="remover_producto.php?id_producto=<?php echo $id_producto; ?>">Eliminar</a></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>
<h2>Total: <?php echo htmlspecialchars($total); ?></h2>
