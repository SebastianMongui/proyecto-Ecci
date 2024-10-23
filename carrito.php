<?php
session_start();
require 'db/database.php';

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ?");
    $stmt->execute([$id]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($producto) {
        $_SESSION['carrito'][$id] = [
            'id' => $producto['id'],
            'nombre' => $producto['nombre'],
            'precio' => $producto['precio'],
            'cantidad' => 1,
            'imagen' => $producto['imagen']
        ];
    }
}

if (isset($_GET['eliminar'])) {
    $idEliminar = $_GET['eliminar'];
    unset($_SESSION['carrito'][$idEliminar]);
}

$total = 0;
foreach ($_SESSION['carrito'] as $item) {
    $total += $item['precio'] * $item['cantidad'];
}

include 'includes/header.php';
?>

    <div class="container mt-5">
        <h2>Carrito de Compras</h2>
        <div class="row">
            <?php if (empty($_SESSION['carrito'])):
                echo '<div class="alert alert-warning text-center" role="alert">
            <h4 class="alert-heading">¡Tu carrito está vacío!</h4>
            <p>Actualmente no tienes ningún producto en tu carrito. Explora nuestra tienda para encontrar lo que más te gusta.</p>
            <a href="index.php" class="btn btn-primary">Volver a la tienda</a>
          </div>';
          exit;
          ?>
            <?php else: ?>
                <?php foreach ($_SESSION['carrito'] as $id => $item): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <img src="img/<?php echo htmlspecialchars($item['imagen']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($item['nombre']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($item['nombre']); ?></h5>
                                <p class="card-text">Precio: $<?php echo htmlspecialchars($item['precio']); ?></p>
                                <p class="card-text">Cantidad: <?php echo $item['cantidad']; ?></p>
                                <a href="?eliminar=<?php echo $id; ?>" class="btn btn-danger">Eliminar</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <h4>Total: $<?php echo number_format($total, 2); ?></h4>
        <a href="index.php" class="btn btn-light">Volver a la Tienda</a>
        <a href="checkout.php" class="btn btn-success">Proceder al Pago</a>
    </div>
    <?php include 'includes/header.php'; ?>
