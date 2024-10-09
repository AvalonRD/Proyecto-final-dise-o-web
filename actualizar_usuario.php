<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" || $_SERVER["REQUEST_METHOD"] == "GET") {
    $id_usuario = $_REQUEST["id_usuario"];
    $usuario = $_REQUEST['usuario'];
    $clave = $_REQUEST['clave'];
    $nombre = $_REQUEST['nombre'];
    $correo = $_REQUEST['correo'];
}


include('db_config.php');
$conn = conectarDB();
$response = array(); // Crear un array para la respuesta

if (is_string($conn)) {
    $response['error'] = $conn; 
} else {
    $sql = "UPDATE usuarios SET usuario='$usuario', clave='$clave', nombre='$nombre', correo='$correo' WHERE id_usuario='$id_usuario'";
    
    if ($conn->query($sql) === TRUE) {
        $response['success'] = true;
    } else {
        $response['error'] = "Error al actualizar el usuario: " . $conn->error;
    }
    $conn->close();

}

echo json_encode($response); // Devolver JSON
?>
