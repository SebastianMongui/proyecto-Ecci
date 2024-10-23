<?php session_start();
      include 'includes/header.php';
      include 'includes/navbar.php';
      include 'db/database.php';
?>

<div class="container">
    <div class="container mt-4">
        <h1 class="text-center">Bienvenido a B-Tech</h1>
        <p class="text-center">Explora nuestras últimas tendencias en tecnología.</p>
    </div>
    <div class="banner">
        <iframe
        src="https://www.youtube.com/embed/0okuAwqTHs0?autoplay=1&loop=1&playlist=0okuAwqTHs0&controls=1&mute=1"
        title="Adidas"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
        allowfullscreen>
        </iframe>
    </div>
    
    <div class="productos-destacados mt-5">
        <h2>Productos Destacados</h2>
        <div class="row g-4">
            <?php
            // Realiza la consulta para obtener los primeros 9 productos
            $sql = "SELECT * FROM productos LIMIT 9 ";
            //stmt es un objeto devuelto de pdo y asi tiene acceso a otros metodos como execute :p 
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            // Itera sobre los resultados, cada registro de la bd es una iteración, solo ejecutara el bloque de código cuando haya un array.
            while ($producto = $stmt->fetch(PDO::FETCH_ASSOC)) {
                /*echo '<pre><br>';
                print_r($producto);
                echo '</pre>';*/
                echo '<div class="col-md-4">
                        <div class="card h-100 d-flex flex-column">
                            <img src="img/' . htmlspecialchars($producto['imagen']) . '" class="card-img-top" alt="' . htmlspecialchars($producto['nombre']) . '" onerror="this.onerror=null; this.src=\'img/default.png\';">
                            <div class="card-body">
                                <h5 class="card-title">' . htmlspecialchars($producto['nombre']) . '</h5>
                                <p class="card-text">' . htmlspecialchars($producto['descripcion']) . '</p>';
                if (isset($_SESSION['usuario_id'])) {
                                echo '<a href="producto.php?id=' . $producto['id'] . '" class="btn btn-primary">Comprar</a>';
                } else {
                                echo '<a href="login.php" class="btn btn-primary">Logearse</a>';
                }
                echo '
                            </div>
                        </div>
                    </div>';
            }
            ?>
        </div>
    </div>
<script src="js/validations.js"></script>
<?php include 'includes/footer.php'; ?>
