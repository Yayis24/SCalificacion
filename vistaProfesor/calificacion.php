<?php
include_once '../modelo/conexion.php';
$objeto = new conexion();
$conexion = $objeto->Conectar();

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
                    <th>Nombre</th>
                    <th>Grado</th>
                    <th>Notas</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario) : ?>
                    <tr>
                        <td><?php echo $usuario['Id']; ?></td>
                        <td><?php echo $usuario['Nombre']; ?></td>
                        <td><?php echo $usuario['Grado']; ?></td>
                        <td><a href="notas.php?usuario_id=<?php echo $usuario['Id']; ?>"><i class="fa-solid fa-star-half-stroke" id="nota"></i></a></td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No se encontraron aprendices para el grado seleccionado.</p>
    <?php endif; ?>
</body>
</html>