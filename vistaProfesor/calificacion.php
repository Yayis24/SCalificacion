<?php
include_once '../modelo/conexion.php';
$objeto = new conexion();
$conexion = $objeto->Conectar();

$consultaProfesores = "SELECT * FROM profesor";
$resultadoProfesores = $conexion->prepare($consultaProfesores);
$resultadoProfesores->execute();
$profesores = $resultadoProfesores->fetchAll(PDO::FETCH_ASSOC);

$consultaA = "SELECT * FROM aprendices";
$resultadoA = $conexion->prepare($consultaA);
$resultadoA->execute();
$aprendiz = $resultadoA->fetchAll(PDO::FETCH_ASSOC);

$consultaMaterias = "SELECT * FROM materia";
$resultadoMaterias = $conexion->prepare($consultaMaterias);
$resultadoMaterias->execute();
$materias = $resultadoMaterias->fetchAll(PDO::FETCH_ASSOC);


$consultaCali = "SELECT c.*, c.Id, c.Id_Profesor, c.Id_Alumno, c.Id_Materia, c.Promedio, p.Docente AS NombreProfe,
                    m.Nombre AS MateriaName
                    FROM calificacion c
                    INNER JOIN profesor p ON c.Id_Profesor = p.Id
                    INNER JOIN aprendices a ON c.Id_Alumno = a.Id
                    INNER JOIN materia m ON c.Id_Materia = m.Id";
$resultadoC = $conexion->prepare($consultaCali);
$resultadoC->execute();
$Calificacion = $resultadoC->fetchAll(PDO::FETCH_ASSOC);

$consultaGrados = "SELECT DISTINCT Grado FROM cursos";
$resultadoGrados = $conexion->query($consultaGrados);
$grados = $resultadoGrados->fetchAll(PDO::FETCH_COLUMN);


// Consulta SQL para obtener todos los aprendices
$consultaTodos = "SELECT aprendices.Id, aprendices.Nombre, cursos.Grado
                FROM aprendices 
                JOIN cursos ON aprendices.Id_Cursos = cursos.Id";

// Ejecutar la consulta para obtener todos los aprendices
$resultadoTodos = $conexion->query($consultaTodos);
$usuariosTodos = $resultadoTodos->fetchAll(PDO::FETCH_ASSOC);

// Verificar si se ha enviado el formulario y se ha seleccionado un grado
if (isset($_POST['submit']) && isset($_POST['grado'])) {
    $gradoSeleccionado = $_POST['grado'];

    // Consulta SQL con filtro de grado
    $consulta = "SELECT aprendices.Id, aprendices.Nombre, cursos.Grado 
                FROM aprendices 
                JOIN cursos ON aprendices.Id_Cursos = cursos.Id 
                WHERE cursos.Grado = :grado";

    // Preparar la consulta
    $resultado = $conexion->prepare($consulta);
    $resultado->bindParam(':grado', $gradoSeleccionado, PDO::PARAM_STR);

    // Ejecutar la consulta
    $resultado->execute();

    // Obtener los resultados
    $usuarios = $resultado->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Mostrar todos los aprendices generales
    $usuarios = $usuariosTodos;
}
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
    <title>Calificaciones</title>
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
    <h1 id="inicio">Calificaciones</h1>

    <form method="POST" action="">
        <label for="grado">Selecciona un grado:</label>
        <select name="grado" id="grado">
            <option align="center"> Seleccione </option>
            <?php foreach ($grados as $grado) : ?>
                <option value="<?php echo $grado; ?>"><?php echo $grado; ?></option>
            <?php endforeach; ?>
        </select>
        <button id="Filtro" type="submit" name="submit">Filtrar</button>
    </form>

    <?php if (!empty($usuarios)) : ?>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>Id</th>
                    <th>Estudiante</th>
                    <th>Grado</th>
                    <th>Calificar</th>

                </tr>
            </thead>
            <tbody>
            <?php foreach ($usuarios as $usuario) : ?>
                <tr>
                    <td><?php echo $usuario['Id']; ?></td>
                    <td><?php echo $usuario['Nombre']; ?></td>
                    <td><?php echo $usuario['Grado']; ?></td>
                    <td><a href="#" id="add" class="addnotas" data-id="<?php echo $usuario['Id']; ?>"><i class="fa-solid fa-star-half-stroke"></i></a></td>
                </tr>
            <?php endforeach; ?>

            </tbody>
        </table>
    <?php else : ?>
        <h3><p>No se encontraron aprendices para el grado seleccionado</p></h3>
    <?php endif; ?>

        <!-- Modal de agregar notas -->

        <div id="modal" class="modal">
    <div class="modal-content">
        <h2>Asignar notas</h2>
        <form action="../controlador/controlnotas.php" id="editForm" method="post">
            <input type="hidden" name="id" id="update_id" value="">

            <div>
                <label for="Name">Aprendiz:</label>
                <input id="Name" name="Id" readonly="readonly">
            </div>


            <div>
                <label for="Id_Profesor">Profesor:</label>
                <select id="Id_Profesor" name="Id_Profesor">
                <?php foreach ($profesores as $profesor) : ?>
                    <option> <?php echo $profesor['Id']?>-<?php echo $profesor['Docente']?></option>
                <?php endforeach; ?>
                </select>
            </div>
            
            <div>
                <label for="Id_Materia">Materia:</label>
                <select id="Id_Materia" name="Id_Materia">
                <?php foreach ($materias as $materia) : ?>
                    <option> <?php echo $materia['Id']?>-<?php echo $materia['Nombre']?></option>
                <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="Nota1">Nota 1:</label>
                <input type="text" id="Nota1" name="Nota1" value="0" onchange="calcularPromedio(this)" onkeyup="calcularPromedio(this)">
            </div>
            <div>
                <label for="Nota2">Nota 2:</label>
                <input type="text" id="Nota2" name="Nota2" value="0" onchange="calcularPromedio(this)" onkeyup="calcularPromedio(this)">
            </div>
            <div>
                <label for="Nota3">Nota 3:</label>
                <input type="text" id="Nota3" name="Nota3" value="0" onchange="calcularPromedio(this)" onkeyup="calcularPromedio(this)">
            </div>
            <!-- Agrega el campo Promedio si también necesitas mostrarlo -->
            <div>
                <label for="Promedio">Promedio:</label>
                <input type="text" id="Promedio" name="promedio" value="0" readonly="readonly">
            </div><br>

            <button type="submit">Guardar</button>
            <button type="button" id="cerrarmodal">Cancelar</button>
        </form>
    </div>
</div>

    <!-- Script para logica de notas -->

<script>
    function calcularPromedio(input) {
        var row = input.parentNode.parentNode;
        var nota1 = parseFloat(row.querySelector('input[name="Nota1"]').value);
        var nota2 = parseFloat(row.querySelector('input[name="Nota2"]').value);
        var nota3 = parseFloat(row.querySelector('input[name="Nota3"]').value);
        var promedioInput = row.querySelector('input[name^="promedio"]');
        
        var promedio = (nota1 + nota2 + nota3) / 3;
        promedioInput.value = promedio.toFixed(2);
    }
</script>

<!-- Script de agregar notas -->

<script>
    $('.addnotas').on('click', function() {

        var enlaceId = this.id; // Obtener el id del enlace clicado
        var estudianteId = $(this).data('id'); // Obtener el ID del estudiante

        // Obtener los datos de la fila seleccionada
        $tr = $(this).closest('tr');
        var datos = $tr.children("td").map(function() {
            return $(this).text();
        }).get();

        // Rellenar los campos del formulario de edición con los datos obtenidos
        $('#update_id').val(datos[0]);
        $('#Name').val(estudianteId);
        $('#Id_Profesor').val(datos[2]);
        $('#Id_Materia').val(datos[3]);
        $('#Nota1').val(datos[4]);
        $('#Nota2').val(datos[5]);
        $('#Nota3').val(datos[6]);
        $('#promedio').val(datos[7]);

        // Abrir el modal de edición
        $('#modal').css('display', 'block');

        $('#cerrarmodal').on('click', function() {
            // Cerrar el modal
            $('#modal').css('display', 'none');
        });
    });
</script>


</body>
</html>