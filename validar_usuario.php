<?php
session_start(); // Iniciar la sesión
include('db_config.php');
$conn = conectarDB();

if (is_string($conn)) {
    echo json_encode(['error' => 'No se pudo conectar a la base de datos.']);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = htmlspecialchars($_POST['usuario'], ENT_QUOTES, 'UTF-8');
    $clave = htmlspecialchars($_POST['clave'], ENT_QUOTES, 'UTF-8');
    $tipoUsuario = htmlspecialchars($_POST['tipo'], ENT_QUOTES, 'UTF-8'); // Obtener el tipo de usuario

    // Verificar que los campos no estén vacíos
    if (empty($usuario) || empty($clave)) {
        echo json_encode(0); // Datos incorrectos
        exit;
    }

    if ($tipoUsuario === 'administrador') {
        // Verificar administrador
        $stmt = $conn->prepare("SELECT passwd_adm FROM admin WHERE user_adm = ?");
        $stmt->bind_param("s", $usuario);
    } else {
        // Verificar cliente
        $stmt = $conn->prepare("SELECT passwd_clt FROM client WHERE username = ?");
        $stmt->bind_param("s", $usuario);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verificar la contraseña
        if ($tipoUsuario === 'administrador') {
            if ($clave === $row['passwd_adm']) {
                $_SESSION['usuario'] = $usuario; // Guardar el usuario en la sesión
                echo json_encode(1); // Éxito
            } else {
                echo json_encode(0); // Datos incorrectos
            }
        } else {
            if ($clave === $row['passwd_clt']) {
                $_SESSION['usuario'] = $usuario; // Guardar el usuario en la sesión
                echo json_encode(2); // Éxito
            } else {
                echo json_encode(0); // Datos incorrectos
            }
        }
    } else {
        echo json_encode(0); // Datos incorrectos
    }

    $stmt->close();
    $conn->close();
}
?>
