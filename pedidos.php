<?php
session_start();
require 'db/database.php'; 

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php'); 
    exit();
}

$userId = $_SESSION['usuario_id'];

$stmt = $pdo->prepare("SELECT id, fecha_pedido, total, estado FROM pedidos WHERE usuario_id = ? ORDER BY fecha_pedido DESC");
$stmt->execute([$userId]);
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$detalles = [];

if (isset($_GET['pedido_id'])) {
    $pedidoId = intval($_GET['pedido_id']);
    
    $stmt = $pdo->prepare("SELECT dp.cantidad, p.nombre, dp.precio_unitario 
                            FROM detalle_pedido dp 
                            JOIN productos p ON dp.producto_id = p.id 
                            WHERE dp.pedido_id = ?");
    $stmt->execute([$pedidoId]);
    $detalles = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

include 'includes/header.php';
include 'includes/navbar.php';
?>

<div class="container my-5">
    <h1 class="text-center mb-4">Mis Pedidos</h1>

    <?php if (empty($pedidos)): ?>
        <div class="alert alert-info text-center">No tienes pedidos realizados.</div>
    <?php else: ?>
        <table class="table table-striped table-bordered mt-3">
            <thead class="table-primary">
                <tr>
                    <th>ID Pedido</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Detalles</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $pedido): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($pedido['id']); ?></td>
                        <td><?php echo htmlspecialchars($pedido['fecha_pedido']); ?></td>
                        <td>$<?php echo number_format($pedido['total'], 2); ?></td>
                        <td><?php echo htmlspecialchars($pedido['estado']); ?></td>
                        <td>
                            <a href="?pedido_id=<?php echo htmlspecialchars($pedido['id']); ?>" class="btn btn-info btn-sm">Ver Detalles</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <?php if (!empty($detalles)): ?>
        <h2 class="mt-5 text-center">Detalles del Pedido ID: <?php echo htmlspecialchars($pedidoId); ?></h2>
        <table class="table table-striped table-bordered mt-3">
            <thead class="table-secondary">
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($detalles as $detalle): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($detalle['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($detalle['cantidad']); ?></td>
                        <td>$<?php echo number_format($detalle['precio_unitario'], 2); ?></td>
                        <td>$<?php echo number_format($detalle['cantidad'] * $detalle['precio_unitario'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
