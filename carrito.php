<?php
session_start();

if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
    echo "<table>";
    echo "<tr><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Total</th><th>Acciones</th></tr>";

    $total = 0;
    foreach ($_SESSION['carrito'] as $producto) {
        $subtotal = $producto['precio'] * $producto['cantidad'];
        $total += $subtotal;
        echo "<tr>";
        echo "<td>{$producto['nombre']}</td>";
        echo "<td>{$producto['precio']}</td>";
        echo "<td>{$producto['cantidad']}</td>";
        echo "<td>{$subtotal}</td>";
        echo "<td><a href='remover_producto.php?id={$producto['id']}'>Eliminar</a></td>";
        echo "</tr>";
    }

    echo "<tr><td colspan='3'>Total:</td><td>{$total}</td></tr>";
    echo "</table>";
} else {
    echo "<p>No hay productos en el carrito.</p>";
}
?>
