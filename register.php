<?php 
    include 'includes/header.php';
    include 'includes/navbar.php';
?>

<div class="container">
    <h1>Registrarse en la Tienda</h1>
    <form id="register-form" action="register.php" method="POST">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre Completo</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="mb-3">
            <label for="correo" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="correo" name="correo" required>
        </div>
        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion" required>
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrarse</button>
    </form>
</div>

<script src="js/validations.js"></script>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'db/database.php';
    /*echo '<pre>';
    print_r($_POST);
    echo '</pre>';*/
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    //echo 'que monda es el hash -> '; print_r($password);

    $sql = "INSERT INTO usuarios (nombre, correo, contrasena, telefono, direccion) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre, $correo, $password, $telefono, $direccion]);

    echo '<div class="alert alert-success" role="alert" style="margin-top: 56px;">';
    echo 'Registro exitoso. ¡Bienvenido a nuestra tienda!';
    echo '<br><a href="index.php" class="btn btn-primary mt-2">Ir a la Tienda</a>';
    echo '</div>';
}

include 'includes/footer.php';
?>
