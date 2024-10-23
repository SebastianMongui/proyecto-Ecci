<?php
session_start();
include 'includes/header.php';
include 'includes/navbar.php';

if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo '<div class="text-center my-5">';
    echo '<h1>Tu carrito está vacío</h1>';
    echo '<a href="index.php" class="btn btn-primary">Volver a la tienda</a>';
    echo '</div>';
    exit;
}

if (isset($_GET['eliminar'])) {
    $idEliminar = $_GET['eliminar'];
    unset($_SESSION['carrito'][$idEliminar]);
    /* Redirigir a la misma p�gina para evitar reenv�os al actualizar
    header("Location: carrito.php");
    exit();*/
}

$total = 0;
?>

<div class="container">
    <h1>Carrito de Compras</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php 
            if (empty($_SESSION['carrito'])){
                echo '<div class="alert alert-warning text-center" role="alert">
            <h4 class="alert-heading">¡Tu carrito está vacío!</h4>
            <p>Actualmente no tienes ningún producto en tu carrito. Explora nuestra tienda para encontrar lo que más te gusta.</p>
            <a href="index.php" class="btn btn-primary">Volver a la tienda</a>
          </div>';
          exit;
            } else {
                 foreach ($_SESSION['carrito'] as $key => $item):
                 
        ?>
                <tr>
                    <td><img src="img/<?php echo $item['imagen']; ?>" alt="<?php echo $item['nombre']; ?>" width="100"></td>
                    <td><?php echo $item['nombre']; ?></td>
                    <td>$<?php echo number_format($item['precio'], 2); ?></td>
                    <td><?php echo $item['cantidad']; ?></td>
                    <td>$<?php echo number_format($item['precio'] * $item['cantidad'], 2); ?></td>
                    <td>
                        <a href="?eliminar=<?php echo $key; ?>" class="btn-remove">Eliminar</a>
                    </td>
                </tr>
                <?php $total += $item['precio'] * $item['cantidad']; ?>
            <?php endforeach;} ?>
        </tbody>
    </table>
    <h3>Total: $<?php echo number_format($total, 2); ?></h3>
    <a href="checkout.php" class="btn btn-success">Proceder a Pago</a>
    <a href="index.php" class="btn btn-secondary">Seguir Comprando</a>
</div>
<?php include 'includes/footer.php'; ?>