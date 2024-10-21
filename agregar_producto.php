<?php
// Conexión a la base de datos
$host = "localhost";
$usuario = "root";
$password = "";
$base_datos = "proyecto_final_web";

$conn = new mysqli($host, $usuario, $password, $base_datos);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];

    // Procesar la imagen
    $imagen_nombre = $_FILES['imagen']['name'];
    $imagen_tmp = $_FILES['imagen']['tmp_name'];
    $ruta_destino = "imagenes/" . $imagen_nombre; // Asume que tienes una carpeta "imagenes"
    move_uploaded_file($imagen_tmp, $ruta_destino);

    // Consulta SQL para insertar los datos en la base de datos
    $sql = "INSERT INTO productos (nombre, descripcion, precio, cantidad, imagen) 
            VALUES ('$nombre', '$descripcion', '$precio', '$cantidad', '$ruta_destino')";

    if ($conn->query($sql) === TRUE) {
        echo "Producto agregado exitosamente";
        header("Location: agregar_producto.html"); // Redirigir de nuevo al formulario
    } else {
        echo "Error al agregar el producto: " . $conn->error;
    }
}

$conn->close();
?>
