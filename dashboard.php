<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}
echo "Bienvenido, " . $_SESSION['usuario'];
// Aquí puedes añadir más funcionalidades para el cliente.
?>
