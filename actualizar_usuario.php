<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" || $_SERVER["REQUEST_METHOD"] == "GET") {
    $user_id = $_REQUEST["user_id"];
    $username = $_REQUEST['username'];
    $passwd = $_REQUEST['passwd'];
    $nombre_user = $_REQUEST['nombre_user'];
    $email = $_REQUEST['email'];
}


include('db_config.php');
$conn = conectarDB();
$response = array(); // Crear un array para la respuesta

if (is_string($conn)) {
    $response['error'] = $conn; 
} else {
    $sql = "UPDATE usuarios SET username='$username', passwd='$passwd', nombre_user='$nombre_user', email='$email' WHERE user_id='$user_id'";
    
    if ($conn->query($sql) === TRUE) {
        $response['success'] = true;
    } else {
        $response['error'] = "Error al actualizar el username: " . $conn->error;
    }
    $conn->close();

}

echo json_encode($response); // Devolver JSON
?>
