<?php

include('db_config.php');
$conn = conectarDB();

if (is_string($conn)) {
    echo $conn; 
} else {
    $sql = "SELECT * FROM usuario";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['username']) . "</td>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>"; 
            echo "</tr>";
        }
    } else {
        echo ""; // Si no hay resultados, no devolver nada
    }

    $conn->close();
}
?>
