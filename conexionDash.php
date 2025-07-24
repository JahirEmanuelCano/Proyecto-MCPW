<?php
//buenas ing, yo utilice mamp para la admin de la base de datos y se asigno el puerto 8889 para este
$host = "localhost:8889";
$usuario = "root";
$contrasena = "root";
$base_datos = "proyecto_portafolio";

try{
$pdo = new PDO("mysql:host=$host;dbname=$base_datos;", $usuario, $contrasena);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>