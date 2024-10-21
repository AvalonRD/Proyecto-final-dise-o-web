<?php
session_start();

// Conectar a la base de datos
include('db_config.php'); // Asegúrate de tener este archivo correctamente configurado
$conn = conectarDB();

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el ID del cliente desde la sesión (por ejemplo, "Juan Pérez" con ID 1)
if (!isset($_SESSION['clt_id'])) {
    echo "Error: No se ha iniciado sesión.";
    exit;
}

$clt_id = $_SESSION['clt_id']; // El cliente autenticado

$sql = "SELECT p.name_pd, pd.quantity, p.price, pd.purchase_id 
        FROM purchase_detail pd 
        JOIN product p ON pd.product_id = p.product_id 
        JOIN purchase pu ON pd.purchase_id = pu.purchase_id 
        WHERE pu.clt_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $clt_id);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si hay resultados
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['purchase_id'] . "</td>
                <td>" . htmlspecialchars($row['name_pd']) . "</td>
                <td>" . htmlspecialchars($row['price']) . "</td>
                <td>" . htmlspecialchars($row['quantity']) . "</td>
              </tr>";
    }
} else {
    echo "<p>No se encontraron compras.</p>";
}

// Cerrar la conexión
$conn->close();
?>
