<?php
session_start();
session_unset(); // Eliminar todas las variables de sesión
session_destroy(); // Destruir la sesión

// Redirigir a la página de inicio
header("Location: index.html");
exit;
?>