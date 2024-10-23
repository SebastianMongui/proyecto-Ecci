<?php
$host = 'localhost';
$dbname = 'proyecto_html';
$user = 'root'; // Cambiar si tienes otro usuario configurado
$password = ''; // Cambiar si tienes contraseña

try {
    // Aqui se llama la clase PDO, por lo tanto la varible $pdo es un objeto.
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    // Control de errores :)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error de conexión: ' . $e->getMessage();
}
?>
