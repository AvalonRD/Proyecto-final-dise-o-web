<?php
session_start();
include('db_config.php');
$conn = conectarDB();

if (is_string($conn)) {
    die("Error de conexión: " . $conn);
}

// Verificar si el cliente está autenticado
if (!isset($_SESSION['clt_id'])) { // Asegúrate de que estás utilizando 'clt_id'
    header("Location: login.html"); // Redirigir al login si no está autenticado
    exit;
}

// Obtener todos los productos
$query = "SELECT * FROM product";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/comprar.css">
    <script>
        function comprarProducto(idProducto, precio) {
            const confirmation = confirm("¿Estás seguro de que deseas comprar este producto?");
            if (confirmation) {
                // Redirigir al archivo agregar_venta.php pasando el id del producto y el precio como parámetros
                window.location.href = "agregar_venta.php?id_producto=" + idProducto + "&precio=" + precio;
            }
        }
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Abarrotes</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Cerrar sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="comprar.php">Comprar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="carrito.html">Carrito</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <h2>Productos Disponibles</h2>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Foto</th>
                    <th>Nombre del Producto</th>
                    <th>Precio</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="<?php echo htmlspecialchars($row['name_pd']); ?>" class="product-image" width="100"></td>
                    <td><?php echo htmlspecialchars($row['name_pd']); ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <td><button class="btn btn-primary" onclick="comprarProducto(<?php echo $row['product_id']; ?>, <?php echo $row['price']; ?>)">Comprar</button></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <footer class="bg-light text-center py-3">
        <p>Versión 1.0 | Abarrotes © 2024</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
