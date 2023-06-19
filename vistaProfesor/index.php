
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image" href="../IMG/lo429356.png">
    <script src="https://kit.fontawesome.com/1ade5e208e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/tarjeta.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Inicio</title>
</head>

<body>
    <div class="navegacion" id="contenedor2">
        <ul>

            <li>
                <a href="index.php" class="seleccionado">
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
                <a href="calificacion.php">
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
        <h1 id="inicio">Bienvenido al sistema de calificacion</h1>
        <h4 id="info">Este es un espacio informativo donde podras visualizar las actividades que, como docente, podras realizar:</h4><hr>

        <main>
            <div class="container-box">
                <div class="box box1">
                    <img src="../IMG/acti.png" alt="">
                    <h1>Reportes</h1>
                    <div class="container-p">
                    <p>Puedes realizar reporte de cada estudiante dependiendo su curso.</p>
                    </div>
               <!--      <div class="check">
                        <i class="fa-solid fa-check"></i>
                    </div> -->
                </div>

                <div class="box box2">
                    <img src="../IMG/materias.png" alt="">
                    <h1>Materias</h1>
                    <div class="container-p">
                    <p>Califica las materias de un estudiante de una manera rapida y sencilla</p>
                    </div>
               <!--      <div class="check">
                        <i class="fa-solid fa-check"></i>
                    </div> -->
                </div>

                <div class="box box3">
                    <img src="../IMG/docente.png" alt="">
                    <h1>Docentes</h1>
                    <div class="container-p">
                    <p>Como docente puedes editar, eliminar, actualizar los datos de los estudiantes.</p>
                    </div>
                   <!--  <div class="check">
                        <i class="fa-solid fa-check"></i>    
                    </div> -->
                </div>
                
            </div>
        </main>


    </div>

<script src="../js/script.js"></script>

    <body>
    </html>