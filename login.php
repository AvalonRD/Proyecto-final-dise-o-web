<?php
session_start(); // Asegúrate de iniciar la sesión

// Verificar si se enviaron los parámetros necesarios
if (isset($_GET['usuario']) && isset($_GET['clave']) && isset($_GET['tipo']) && $_GET['tipo'] === 'cliente') {
    $usuario = $_GET['usuario'];
    $clave = $_GET['clave'];

    // Conectar a la base de datos
    include('db_config.php');
    $conn = conectarDB();

    if (is_string($conn)) {
        die("Error de conexión: " . $conn);
    }

    // Preparar la consulta para verificar el usuario
    $query = "SELECT * FROM client WHERE username = ? AND passwd_clt = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $usuario, $clave);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Usuario encontrado, establecer variables de sesión
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['clt_id'];
        $_SESSION['username'] = $row['username'];

        // Redirigir al catálogo de productos (comprar.html)
        header("Location: comprar.html"); 
        exit;
    } else {
        echo "Usuario o contraseña incorrectos.";
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
} else {
    echo "Parámetros inválidos.";
}
?>
