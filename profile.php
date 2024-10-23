<?php
session_start();
require 'db/database.php';
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
$usuario_id = $_SESSION['usuario_id'];
$stmt = $pdo->prepare("SELECT nombre, correo, direccion, telefono FROM usuarios WHERE id = ?");
$stmt->execute([$usuario_id]);
$usuario = $stmt->fetch();

if (!$usuario) {
    echo '<div class="alert alert-danger text-center">Usuario no encontrado.</div>';
    exit();
}

include 'includes/header.php';
include 'includes/navbar.php';
?>

<div class="container my-5">
    <h1 class="text-center">Perfil de Usuario</h1>
    <div class="card shadow-sm p-4">
        <h4 class="card-title mb-4">Información Básica</h4>
        <p><strong>Nombre:</strong> <?php echo htmlspecialchars($usuario['nombre']); ?></p>
        <p><strong>Correo Electrónico:</strong> <?php echo htmlspecialchars($usuario['correo']); ?></p>
        <p><strong>Dirección:</strong> <?php echo htmlspecialchars($usuario['direccion']); ?></p>
        <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($usuario['telefono']); ?></p>
    </div>
    
    <div class="text-center mt-4">
        <a href="editarPerfil.php" class="btn btn-primary">Editar Perfil</a>
        <a href="index.php" class="btn btn-secondary">Volver a la Tienda</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
