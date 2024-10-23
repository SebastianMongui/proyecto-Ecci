<?php
session_start();
require 'db/database.php'; 

$categoriaId = isset($_GET['categoria_id']) ? (int)$_GET['categoria_id'] : null;

$productosPorPagina = 8; 
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($paginaActual - 1) * $productosPorPagina;

$stmt = $pdo->prepare("SELECT * FROM categorias");
$stmt->execute();
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT COUNT(*) as total FROM productos" . ($categoriaId ? " WHERE categoria_id = ?" : "");
$stmt = $pdo->prepare($query);
if ($categoriaId) {
    $stmt->execute([$categoriaId]);
} else {
    $stmt->execute();
}
$totalProductos = $stmt->fetchColumn();
$totalPaginas = ceil($totalProductos / $productosPorPagina);

$query = "SELECT * FROM productos" . ($categoriaId ? " WHERE categoria_id = ? LIMIT ? OFFSET ?" : " LIMIT ? OFFSET ?");
$stmt = $pdo->prepare($query);
if ($categoriaId) {
    $stmt->bindParam(1, $categoriaId, PDO::PARAM_INT);
    $stmt->bindParam(2, $productosPorPagina, PDO::PARAM_INT);
    $stmt->bindParam(3, $offset, PDO::PARAM_INT);
} else {
    $stmt->bindParam(1, $productosPorPagina, PDO::PARAM_INT);
    $stmt->bindParam(2, $offset, PDO::PARAM_INT);
}
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'includes/header.php';
include 'includes/navbar.php';
?>

<div class="container my-5">
    <h1 class="text-center mb-4">Productos</h1>
    <div class="row mb-4 justify-content-center">
        <?php foreach ($categorias as $categoria): ?>
            <div class="col-md-2 text-center">
                <a href="?categoria_id=<?php echo $categoria['id']; ?>" class="btn btn-secondary w-100 mb-2">
                    <?php echo htmlspecialchars($categoria['nombre']); ?>
                </a>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="row">
        <?php foreach ($productos as $producto): ?>
            <div class="col-md-3 mb-3">
                <div class="card h-100">
                    <img src="img/<?php echo htmlspecialchars($producto['imagen']); ?>" 
                         class="card-img-top" 
                         alt="<?php echo htmlspecialchars($producto['nombre']); ?>" 
                         onerror="this.onerror=null; this.src='img/default.png';">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($producto['nombre']); ?></h5>
                        <p class="card-text">Precio: $<?php echo number_format($producto['precio'], 2); ?></p>
                        <a href="producto.php?id=<?php echo $producto['id']; ?>" class="btn btn-primary">Ver Detalles</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item <?php if($paginaActual <= 1){ echo 'disabled'; } ?>">
                <a class="page-link" href="?categoria_id=<?php echo $categoriaId; ?>&pagina=<?php echo $paginaActual - 1; ?>">Anterior</a>
            </li>
            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                <li class="page-item <?php if($i == $paginaActual) { echo 'active'; } ?>">
                    <a class="page-link" href="?categoria_id=<?php echo $categoriaId; ?>&pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?php if($paginaActual >= $totalPaginas){ echo 'disabled'; } ?>">
                <a class="page-link" href="?categoria_id=<?php echo $categoriaId; ?>&pagina=<?php echo $paginaActual + 1; ?>">Siguiente</a>
            </li>
        </ul>
    </nav>
</div>

<?php include 'includes/footer.php'; ?>
