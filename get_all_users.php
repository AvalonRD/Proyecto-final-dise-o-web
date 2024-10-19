<?php

include('db_config.php');
$conn = conectarDB();

if (is_string($conn)) {
    echo $conn; 
} else {
    $sql = "SELECT * FROM client";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['clt_id']) . "</td>";        // ID del cliente
            echo "<td>" . htmlspecialchars($row['name_clt']) . "</td>";      // Nombre
            echo "<td>" . htmlspecialchars($row['username']) . "</td>";      // Usuario
            echo "<td>" . htmlspecialchars($row['passwd_clt']) . "</td>";    // Contraseña
            echo "<td>" . htmlspecialchars($row['email_clt']) . "</td>";     // Correo electrónico
            echo "<td>" . htmlspecialchars($row['phone_clt']) . "</td>";     // Teléfono
            echo "<td>" . htmlspecialchars($row['address_clt']) . "</td>";   // Dirección
            echo "</tr>";
        }
    } else {
        echo ""; // Si no hay resultados, no devolver nada
    }

    $conn->close();
}
?>
