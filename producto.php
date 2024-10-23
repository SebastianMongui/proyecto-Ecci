<?php
include 'db/database.php';
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $producto = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($producto) {
        include 'includes/header.php';
        ?>
        <div class="container mt-5 product-container">
            <div class="row">
                <div class="col-md-6 text-center">
                    <img src="img/<?php echo htmlspecialchars($producto['imagen']); ?>" class="img-fluid product-image" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                </div>
                <div class="col-md-6">
                    <h2 class="product-title"><?php echo htmlspecialchars($producto['nombre']); ?></h2>
                    <p class="product-description"><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                    <h4 class="product-price">Precio: $<?php echo htmlspecialchars($producto['precio']); ?></h4>
                    <?php 
                        if (isset($_SESSION['usuario_id'])) {
                            echo '<a href="carrito.php?id='.$producto['id'].'" class="btn btn-primary">Agregar al Carrito</a>';
                        } else {
                            echo '<a href="login.php" class="btn btn-primary">Logearse</a>';
                        }
                    ?>
                </div>
            </div>
            <a href="index.php" class="btn btn-primary mt-3">Volver a la Tienda</a>
        </div>
        <?php

        include 'includes/footer.php';
    } else {
        include 'includes/header.php';
        echo "<div class='container mt-5'><h3>Producto no encontrado.</h3></div>";
        include 'includes/footer.php';
    }
} else {
    include 'includes/header.php';
    echo "<div class='container mt-5'><h3>ID de producto no proporcionado.</h3></div>";
    include 'includes/footer.php';
}
?>
