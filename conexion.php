<?php
//buenas ing, yo utilice mamp para la admin de la base de datos y se asigno el puerto 8889 para este
$host = "localhost";
$usuario = "root";
$contrasena = "root";
$base_datos = "proyecto_portafolio";
$puerto_mysql = 8889;

$conexion = new mysqli($host, $usuario, $contrasena, $base_datos, $puerto_mysql);
if ($conexion->connect_error) {
    die("Error de conexion " . $conexion->connect_error);
}
session_start();
?>