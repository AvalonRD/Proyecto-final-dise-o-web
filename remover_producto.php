<?php
session_start();

if (isset($_GET['id_producto'])) {
    $id_producto = $_GET['id_producto'];
    // Elimina el producto del carrito
    if (isset($_SESSION['carrito'][$id_producto])) {
        unset($_SESSION['carrito'][$id_producto]);
    }
}

// Redirige de vuelta al carrito
header("Location: carrito.html");
exit;
?>
