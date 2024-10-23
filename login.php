<?php 
session_start();
include 'includes/header.php';
include 'includes/navbar.php'; 

if (isset($_SESSION['usuario_id'])) {
    echo '<div class="container text-center">';
    echo '<h1>Bienvenido, ' . htmlspecialchars($_SESSION['correo']) . '!</h1>';
    echo '<div class="alert alert-success" role="alert">';
    echo 'Has iniciado sesión exitosamente.';
    echo '<a href="index.php" class="btn btn-primary mt-3">Ir a la Página Principal</a>';
    echo '</div>';
    echo '</div>';
    include 'includes/footer.php';
    exit(); // Salir para evitar mostrar el formulario
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded">
                <div class="card-header text-center">
                    <h2 class="mb-0 text-white">Iniciar Sesión</h2>
                </div>
                <div class="card-body p-4">
                    <form action="login.php" method="POST">
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="correo" name="correo" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <small class="text-muted">¿No tienes una cuenta? <a href="register.php">Regístrate aquí</a></small>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'db/database.php';

    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE correo = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$correo]);

    $usuario = $stmt->fetch();

    if ($usuario && password_verify($password, $usuario['contrasena'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['correo'] = $usuario['correo'];
        $_SESSION['nom_usuario'] = $usuario['nombre'];
        header("Location: index.php");
        exit(); 
    } else {
        echo '<div class="alert alert-warning text-center" role="alert" style="margin-top: 20px;">';
        echo 'Contraseña Incorrecta. Intente nuevamente';
        echo '</div>';
    }
}

include 'includes/footer.php';
?>
