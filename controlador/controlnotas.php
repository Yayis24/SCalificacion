<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtén los valores enviados desde el formulario
    $aprendizId = $_POST['Id'];
    $profesorId = $_POST['Id_Profesor'];
    $materiaId = $_POST['Id_Materia'];
    $nota1 = $_POST['Nota1'];
    $nota2 = $_POST['Nota2'];
    $nota3 = $_POST['Nota3'];

    // Calcula el promedio
    $promedio = ($nota1 + $nota2 + $nota3) / 3;

    // Conecta a la base de datos
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'scalificacion';
    try {
        $conexion = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepara la consulta SQL para insertar las notas
        $consulta = 'INSERT INTO calificacion (Id_Alumno, Id_Profesor, Id_Materia, Promedio) VALUES (?, ?, ?, ?)';
        $statement = $conexion->prepare($consulta);

        // Ejecuta la consulta con los valores proporcionados
        $statement->execute([$aprendizId, $profesorId, $materiaId, $promedio]);

        // Redirecciona a la página principal o muestra un mensaje de éxito
        echo "<script> alert ('Notas agregadas exitosamente') 
        location.href='../vistaProfesor/calificacion.php'; </script>";
    } catch (PDOException $e) {
        // Manejo de errores en caso de fallo de la conexión o consulta
        echo 'Error: ' . $e->getMessage();
    }
} else {
    // Si se accede directamente a este archivo sin realizar una solicitud POST, redirecciona a la página principal o muestra un mensaje de error
    // header('Location: index.php'); // Redireccionar a la página principal
    echo 'Acceso no válido';
}
