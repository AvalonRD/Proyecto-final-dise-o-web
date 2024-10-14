<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" || $_SERVER["REQUEST_METHOD"] == "GET") {
    // Capturar la variable 'nombre' enviada por POST o GET
    $nombre = $_REQUEST["nombre"] ?? '';

    // Usar include_once para evitar problemas de redeclaración
    include_once('db_config.php');
    $conn = conectarDB();
    
    if (is_string($conn)) {
        echo json_encode(['error' => 'No se pudo conectar a la base de datos.']); 
        exit;
    }

    // Sanitizar la entrada del nombre
    $nombre = htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8');

    // Verificar que el nombre no esté vacío
    if (empty($nombre)) {
        echo json_encode(['error' => 'Por favor, ingresa un nombre.']);
        exit;
    }

    // Definir la consulta
    $sql = "SELECT user_id, nombre_user AS nombre, username AS usuario, email AS correo FROM usuario WHERE nombre_user LIKE ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        echo json_encode(['error' => 'Error en la preparación de la consulta: ' . $conn->error]);
        exit;
    }

    $like_nombre = "%$nombre%";
    $stmt->bind_param("s", $like_nombre);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        $result = $stmt->get_result();

        // Verificar si hay resultados
        if ($result->num_rows > 0) {
            // Construir las filas de la tabla con los resultados
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['user_id']) . "</td>
                        <td>" . htmlspecialchars($row['nombre']) . "</td>
                        <td>" . htmlspecialchars($row['usuario']) . "</td>
                        <td>" . htmlspecialchars($row['correo']) . "</td>
                        <td>
                            <form name='form-modificar' action='modificar_regitro.php' method='POST'>
                                <input type='hidden' name='id_usuario' value='" . htmlspecialchars($row['user_id']) . "'>
                                <input type='submit' value='Modificar'>
                            </form>
                        </td>
                        <td>
                            <button onclick='borrar_registro(" . htmlspecialchars($row['user_id']) . ")'>Borrar</button>
                        </td>
                    </tr>";
            }
        } else {
            // No se encontraron resultados
            echo json_encode(['message' => 'No se encontraron usuarios.']);
        }
    } else {
        echo json_encode(['error' => 'Error en la consulta: ' . $stmt->error]);
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
}
?>
