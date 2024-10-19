<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" || $_SERVER["REQUEST_METHOD"] == "GET") {
    // Capturar la variable 'username' enviada por POST o GET
    $username = $_REQUEST["username"] ?? ''; // Cambié 'nombre' por 'username'

    // Usar include_once para evitar problemas de redeclaración
    include_once('db_config.php');
    $conn = conectarDB();
    
    if (is_string($conn)) {
        echo json_encode(['error' => 'No se pudo conectar a la base de datos.']); 
        exit;
    }

    // Sanitizar la entrada del username
    $username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');

    // Verificar que el username no esté vacío
    if (empty($username)) {
        echo json_encode(['error' => 'Por favor, ingresa un nombre de usuario.']);
        exit;
    }

    // Definir la consulta
    $sql = "SELECT clt_id AS id_cliente, name_clt AS nombre, username AS usuario, email_clt AS correo, phone_clt AS telefono, address_clt AS direccion FROM client WHERE username LIKE ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        echo json_encode(['error' => 'Error en la preparación de la consulta: ' . $conn->error]);
        exit;
    }

    $like_username = "%$username%";
    $stmt->bind_param("s", $like_username);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        $result = $stmt->get_result();

        // Verificar si hay resultados
        if ($result->num_rows > 0) {
            // Construir las filas de la tabla con los resultados
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['id_cliente']) . "</td>
                        <td>" . htmlspecialchars($row['nombre']) . "</td>
                        <td>" . htmlspecialchars($row['usuario']) . "</td>
                        <td>" . htmlspecialchars($row['correo']) . "</td>
                        <td>" . htmlspecialchars($row['telefono']) . "</td>
                        <td>" . htmlspecialchars($row['direccion']) . "</td>
                        <td>
                            <form name='form-modificar' action='modificar_registro.php' method='POST'>
                                <input type='hidden' name='id_usuario' value='" . htmlspecialchars($row['id_cliente']) . "'>
                                <input type='submit' value='Modificar'>
                            </form>
                        </td>
                        <td>
                            <button onclick='borrar_registro(" . htmlspecialchars($row['id_cliente']) . ")'>Borrar</button>
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
