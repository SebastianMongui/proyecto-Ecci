<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B-Tech</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="img/logo.svg" alt="Logo Tienda" width="150" class="me-2">
            <span class="brand-text">B-Tech</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php
                if (!isset($_SESSION['usuario_id'])) {
                    echo '<li class="nav-item">
                            <a class="nav-link" href="register.php">Registrarse</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="login.php">Iniciar Sesión</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="categorias.php">Categorias</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="about.php">Acerca</a>
                          </li>';
                } else {
                    echo '<li class="nav-item">
                            <a class="nav-link" href="categorias.php">Categorias</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="profile.php">Perfil</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="cart.php">Carrito</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="pedidos.php">Mis Pedidos</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                          </li>';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>
</html>
