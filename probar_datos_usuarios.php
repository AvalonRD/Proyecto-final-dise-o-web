<?php
    include('db_config.php');
    $conn = conectarDB();
    if (is_string($conn)) {
        echo $conn; 
    } else {
        // Definir la consulta
        $sql = "SELECT id_usuario, nombre, usuario, correo FROM usuarios";
        // Ejecutar la consulta
        $result = $conn->query($sql);

        // Ver resultados obtenidos
        if ($result->num_rows > 0) {
            // Mostrar los datos de cada fila
            while($row = $result->fetch_assoc()) {
                echo "ID: " . $row["id_usuario"]. " - Nombre: " . $row["nombre"]. " - Usuario: " . $row["usuario"]. " - Correo: " . $row["correo"]. "<br>";
            }
        } else {
            echo "No se encontraron resultados.";
        }

        // Cerrar la conexión
        $conn->close();
    }
?>
