<?php
session_start();
require 'db/database.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['usuario_id'];
$stmt = $pdo->prepare("SELECT nombre, correo, direccion, telefono FROM usuarios WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$mensaje = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $correo = htmlspecialchars(trim($_POST['correo']));
    $direccion = htmlspecialchars(trim($_POST['direccion']));
    $telefono = htmlspecialchars(trim($_POST['telefono']));

    if (empty($nombre) || empty($correo)) {
        $error = 'Por favor, completa todos los campos obligatorios.';
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, correo = ?, direccion = ?, telefono = ? WHERE id = ?");
            $stmt->execute([$nombre, $correo, $direccion, $telefono, $userId]);

            $mensaje = 'Perfil actualizado exitosamente.';
            $nombre = $correo = $direccion = $telefono = '';
        } catch (Exception $e) {
            $error = 'Error al actualizar el perfil: ' . $e->getMessage();
        }
    }
}

include 'includes/header.php';
include 'includes/navbar.php';
?>

<div class="container">
    <h1>Editar Perfil</h1>
    
    <?php if ($mensaje): ?>
        <div class="alert alert-success"><?php echo $mensaje; ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if (!$mensaje):?>
    <form action="editarPerfil.php" method="POST">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($user['nombre']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="correo" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="correo" name="correo" value="<?php echo htmlspecialchars($user['correo']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo htmlspecialchars($user['direccion']); ?>">
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo htmlspecialchars($user['telefono']); ?>">
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
    </form>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
