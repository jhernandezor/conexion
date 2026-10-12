<?php
$host = "localhost";
$dbname = "fce_soporte";
$usuario = "root";
$password = "123456789"; // Si en MySQL Workbench usas contraseña para root, ponla entre estas comillas

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $usuario, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "¡Conexión exitosa a MySQL!";
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>