<?php
$usuarioId = $_GET['usuario_id'];

include_once '../modelo/conexion.php';
$objeto = new conexion();
$conexion = $objeto->Conectar();

$consultaNombre = "SELECT Nombre FROM aprendices WHERE Id = $usuarioId";
$resultadoNombre = $conexion->prepare($consultaNombre);
$resultadoNombre->execute();
$nombreUsuario = $resultadoNombre->fetchColumn();


$consultaCalificaciones = "SELECT c.Id, m.Nombre AS Materia, c.Promedio 
                        FROM calificacion c
                        INNER JOIN materia m ON c.Id_Materia = m.Id";
$resultadoCalificaciones = $conexion->prepare($consultaCalificaciones);
$resultadoCalificaciones->execute();
$calificaciones = $resultadoCalificaciones->fetchAll(PDO::FETCH_ASSOC);


$consultaMaterias = "SELECT * FROM materia";
$resultadoMaterias = $conexion->prepare($consultaMaterias);
$resultadoMaterias->execute();
$materias = $resultadoMaterias->fetchAll(PDO::FETCH_ASSOC);


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
    <link rel="stylesheet" href="../css/modals.css">
    <link rel="stylesheet" href="../css/modaldelete.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Control de notas</title>
    
    <script>
function calcularPromedio(nota1, nota2, nota3, promedioId) {
    var a = parseFloat(nota1),
        b = parseFloat(nota2),
        c = parseFloat(nota3);
    var promedio = (a + b + c) / 3;
    document.getElementById(promedioId).value = promedio.toFixed(2);
}

function guardar(materiaId, promedio) {
    var formData = new FormData();
    formData.append('materiaId', materiaId);
    formData.append('promedio', promedio);

    fetch('guardar_calificaciones.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        console.log(result);
        // Aquí puedes mostrar un mensaje de éxito o realizar otras acciones después de guardar las calificaciones
    })
    .catch(error => {
        console.error(error);
        // Aquí puedes mostrar un mensaje de error o realizar otras acciones en caso de que ocurra un problema
    });
}
</script>
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
                <th>Materia</th>
                <th>Nota1</th>
                <th>Nota2</th>
                <th>Nota3</th>
                <th>Promedio</th>
                <th>Guardar</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($materias as $materia) : ?>
            <tr>
            <td><?php echo $materia['Id']; ?></td>
            <td><?php echo $materia['Nombre']; ?></td>
            <td><input type="number" name="nota1" value="0" onchange="calcularPromedio(this)" onkeyup="calcularPromedio(this)"></td>
            <td><input type="number" name="nota2" value="0" onchange="calcularPromedio(this)" onkeyup="calcularPromedio(this)"></td>
            <td><input type="number" name="nota3" value="0" onchange="calcularPromedio(this)" onkeyup="calcularPromedio(this)"></td>
            <td><input type="number" name="notafinal" value="0" readonly="readonly" disabled></td>
            <td><button type="submit" name="guardar" id="save">Guardar</button></td>
        </tr>

        
            <?php endforeach; ?>
        </tbody>
    </table>
    

</form>

    <!-- Script para logica de notas -->

    <script>
    function calcularPromedio(input) {
        var row = input.parentNode.parentNode;
        var nota1 = parseFloat(row.querySelector('input[name="nota1"]').value);
        var nota2 = parseFloat(row.querySelector('input[name="nota2"]').value);
        var nota3 = parseFloat(row.querySelector('input[name="nota3"]').value);
        var promedioInput = row.querySelector('input[name^="notafinal"]');
        
        var promedio = (nota1 + nota2 + nota3) / 3;
        promedioInput.value = promedio.toFixed(2);
    }
</script>



    </div>
</body>

</html>