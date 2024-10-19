<?php
include('db_config.php');

// Conectar a la base de datos
$conn = conectarDB();

if (is_string($conn)) {
    echo json_encode(["error" => $conn]); // Devolver error como JSON
} else {
    // Definir la consulta
    $sql = "SELECT clt_id, name_clt AS nombre, username, email_clt AS correo FROM client"; //consulta
    // Ejecutar la consulta
    $result = $conn->query($sql);

    // Verificar resultados obtenidos
    if ($result) {
        if ($result->num_rows > 0) {
            $usuarios = []; // Array para almacenar los resultados
            // Obtener los datos de cada fila
            while ($row = $result->fetch_assoc()) {
                $usuarios[] = $row; // Agregar cada usuario al array
            }
            echo json_encode($usuarios); // Devolver resultados como JSON
        } else {
            echo json_encode(["mensaje" => "No se encontraron resultados."]); // Mensaje si no hay resultados
        }
    } else {
        echo json_encode(["error" => "Error en la consulta: " . $conn->error]); // Mensaje de error de la consulta
    }

    // Cerrar la conexión
    $conn->close();
}
?>
