<?php
$usuarioId = $_GET['usuario_id'];

include_once '../modelo/conexion.php';
$objeto = new conexion();
$conexion = $objeto->Conectar();

$consultaNombre = "SELECT Nombre, Id AS numb FROM aprendices WHERE Id = $usuarioId";
$resultadoNombre = $conexion->prepare($consultaNombre);
$resultadoNombre->execute();
$nombreUsuario = $resultadoNombre->fetchColumn();


$consultaCali = "SELECT c.*, c.Id, c.Id_Profesor, c.Id_Alumno, c.Id_Materia, c.Promedio
                    FROM calificacion c
                    INNER JOIN profesor p ON c.Id_Profesor = p.Id
                    INNER JOIN aprendices a ON c.Id_Alumno = a.Id
                    INNER JOIN materia m ON c.Id_Materia = m.Id";
$resultadoC = $conexion->prepare($consultaCali);
$resultadoC->execute();
$Calificacion = $resultadoC->fetchAll(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image" href="../IMG/lo429356.png">
    <script src="https://kit.fontawesome.com/1ade5e208e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/tabla.css">
    <link rel="stylesheet" href="../css/modaldelete.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Control de notas</title>
    
</head>

<body>
    <div class="navegacion" id="contenedor">
        <ul>

            <li>
                <a href="index.php">
                    <span class="icono">
                        <i class="fa-solid fa-house"></i>
                    </span>
                    <span class="titulo">Inicio</span>
                </a>
            </li>

            <li>
                <a href="estudiante.php">
                    <span class="icono">
                        <i class="fa-solid fa-address-card"></i>
                    </span>
                    <span class="titulo">Estudiantes</span>
                </a>
            </li>

            <li>
                <a href="calificacion.php" class="seleccionado">
                    <span class="icono">
                        <i class="fa-solid fa-file"></i>
                    </span>
                    <span class="titulo">Calificaciones</span>
                </a>
            </li>

            <li>
                <a href="../logout.php" id="sesion">
                    <span class="icono">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </span>
                    <span class="titulo">Cerrar Sesion</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="contenido">
    <h1 id="inicio">Control de notas de <?php echo $nombreUsuario; ?></h1>
        <a href="calificacion.php"><i class="fa-solid fa-circle-left fa-beat" id="back"></i></a>



<form action="guardardatos.php" method="POST">
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th>Id</th>
                <th>Id Docente</th>
                <th>Id Estudiante</th>
                <th>Id Materia</th>
                <th>Nota1</th>
                <th>Nota2</th>
                <th>Nota3</th>
                <th>Promedio</th>
                <th>Guardar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($Calificacion as $Cali) : ?>
                <tr>
                    <td><?php echo $Cali['Id']; ?></td>
                    <td><?php echo $Cali['Id_Profesor']; ?></td>
                    <td><?php echo $Cali['Id_Alumno']; ?></td>
                    <td><?php echo $Cali['Id_Materia']; ?></td>
                    <td><input type="number" name="nota1[]" value="0" onchange="calcularPromedio(this)" onkeyup="calcularPromedio(this)"></td>
                    <td><input type="number" name="nota2[]" value="0" onchange="calcularPromedio(this)" onkeyup="calcularPromedio(this)"></td>
                    <td><input type="number" name="nota3[]" value="0" onchange="calcularPromedio(this)" onkeyup="calcularPromedio(this)"></td>
                    <td><input type="number" name="promedio" value="0" readonly="readonly"></td>
                    <td><button type="submit" name="guardar[]"><i class="fa-solid fa-floppy-disk save"></i></button></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</form>


    <!-- Script para logica de notas -->

    <script>
    function calcularPromedio(input) {
        var row = input.parentNode.parentNode;
        var nota1 = parseFloat(row.querySelector('input[name="nota1[]"]').value);
        var nota2 = parseFloat(row.querySelector('input[name="nota2[]"]').value);
        var nota3 = parseFloat(row.querySelector('input[name="nota3[]"]').value);
        var promedioInput = row.querySelector('input[name^="promedio"]');
        
        var promedio = (nota1 + nota2 + nota3) / 3;
        promedioInput.value = promedio.toFixed(2);
    }
</script>



    </div>
</body>

</html>