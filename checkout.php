<?php
session_start();
include 'includes/header.php';
include 'includes/navbar.php';
require 'db/database.php';

if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo '<div class="alert alert-warning text-center my-5">Tu carrito está vacío. <a href="index.php" class="alert-link">Volver a la tienda</a></div>';
    exit();
}

$cartItems = $_SESSION['carrito'];
$total = 0;

foreach ($cartItems as $item) {
    $total += $item['precio'] * $item['cantidad'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $correo = htmlspecialchars(trim($_POST['correo']));
    $direccion = htmlspecialchars(trim($_POST['direccion']));

    if (empty($nombre) || empty($correo) || empty($direccion)) {
        echo '<div class="alert alert-danger text-center">Por favor, completa todos los campos.</div>';
    } else {
        try {        
            $pdo->beginTransaction();
        
            $stmt = $pdo->prepare("INSERT INTO pedidos (usuario_id, fecha_pedido, total, estado, direccion_envio) VALUES (?, NOW(), ?, 'pendiente', ?)");
            $stmt->execute([$_SESSION['usuario_id'], $total, $direccion]);
            
            $pedido_id = $pdo->lastInsertId();

            foreach ($cartItems as $id => $item) {
                $stmt = $pdo->prepare("INSERT INTO detalle_pedido (pedido_id, producto_id, cantidad, precio_unitario) VALUES (?, ?, ?, ?)");
                $stmt->execute([$pedido_id, $id, $item['cantidad'], $item['precio']]);
            }

            $pdo->commit();
        
            unset($_SESSION['carrito']);
        
            echo '<div class="alert alert-success text-center my-5">¡Gracias por tu compra! Tu pedido ha sido procesado exitosamente. <a href="index.php" class="alert-link">Volver a la tienda</a></div>';
            exit();
        } catch (Exception $e) {        
            $pdo->rollBack();
            echo '<div class="alert alert-danger text-center">Hubo un error al procesar tu pedido. Por favor, intenta de nuevo. Error: ' . $e->getMessage() . '</div>';
        }
    }
}
?>

<div class="container my-5">
    <h2 class="text-center mb-4">Checkout</h2>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm p-4 border-primary">
                <h4 class="card-title mb-4 text-primary">Resumen de tu pedido</h4>
                <div class="row">
                    <?php foreach ($cartItems as $item): ?>
                    <div class="col-md-6">
                        <div class="card mb-4 shadow-sm">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="img/<?php echo htmlspecialchars($item['imagen']); ?>" alt="<?php echo htmlspecialchars($item['nombre']); ?>" class="img-fluid rounded-start" style="height: 120px; object-fit: cover;">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($item['nombre']); ?></h5>
                                        <p class="card-text">Precio: $<?php echo number_format($item['precio'], 2); ?></p>
                                        <p class="card-text">Cantidad: <?php echo htmlspecialchars($item['cantidad']); ?></p>
                                        <p class="card-text"><strong>Total: $<?php echo number_format($item['precio'] * $item['cantidad'], 2); ?></strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="text-end">
                    <h5>Total de la compra: <strong>$<?php echo number_format($total, 2); ?></strong></h5>
                </div>
            </div>
        </div>

        <?php if ($_SERVER["REQUEST_METHOD"] != "POST") : ?>
        <div class="col-lg-4">
            <div class="card shadow-sm p-4 border-success">
                <h4 class="card-title mb-4 text-success">Detalles de Envío</h4>
                <form action="checkout.php" method="POST">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre Completo</label>
                        <input type="text" value="<?php echo $_SESSION['nom_usuario']; ?>" class="form-control" id="nombre" name="nombre" required placeholder="Ingresa tu nombre completo">
                    </div>
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo Electrónico</label>
                        <input type="email" value="<?php echo $_SESSION['correo']; ?>" class="form-control" id="correo" name="correo" required placeholder="Ingresa tu correo electrónico">
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección de Envío</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" required placeholder="Ingresa tu dirección de envío">
                    </div>
                    <button type="submit" class="btn btn-success w-100">Finalizar Compra</button>
                </form>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-secondary">Volver a la Tienda</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
