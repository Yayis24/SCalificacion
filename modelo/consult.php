<?php
// Establecer la configuración de la conexión a la base de datos
$host = 'localhost';
$usuario = 'root';
$password = '';
$baseDeDatos = 'scalificacion';

// Crear la conexión
$conectar = mysqli_connect($host, $usuario, $password, $baseDeDatos);

// Verificar si la conexión fue exitosa
if (!$conectar) {
    die('Error al conectar a la base de datos: ' . mysqli_connect_error());
}
?>


