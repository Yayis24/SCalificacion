<?php
session_start();
include('includes/coneedt.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['Id'];
    $promedio = $_POST['notafinal'];

    // Insertar los datos en la tabla calificaciones
    $sql = "INSERT INTO calificacion (Id, Promedio) VALUES (:id, :promedio)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->bindParam(':promedio', $promedio, PDO::PARAM_STR);
    $query->execute();

    // Redirigir nuevamente al formulario
    header('Location: promedio.php');
    exit;
}
?>
