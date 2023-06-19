<?php
include_once '../modelo/conexion.php';
$objeto = new conexion();
$conexion = $objeto->Conectar();

$consulta = "SELECT * FROM cursos";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$usuarios = $resultado->fetchAll(PDO::FETCH_ASSOC);

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
    <title>Estudiantes</title>
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
                <a href="estudiante.php" class="seleccionado">
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
        <h1 id="inicio">Agregar estudiantes</h1>
        <a href="estudiante.php"><i class="fa-solid fa-circle-left fa-beat" id="back"></i></a>
        <h4 id="info2">Ingresa los datos del estudiante en el siguiente formulario:</h4><hr>


        <div class="modal-contents">
        <form action="" method="post">
                <input type="hidden" name="id" id="update_id">
                <!-- Campos del formulario de edición -->
<!--                 <div>
                    <label for="Id">Id:</label>
                    <input type="text" id="Id" name="Id" >
                </div> -->
                <div>
                    <label for="Nombre">Nombre:</label>
                    <input type="text" id="Nombre" name="Nombre" >
                </div>
                <div>
                    <label>Tipo de documento:</label>
                    <select id="Tipo_Documento" name="Tipo_Documento">
                        <option value="">Elige</option>
                        <option value="CC">CC</option>
                        <option value="TI">TI</option>
                    </select>
                </div>
                <div>
                    <label for="Documento">Documento:</label>
                    <input type="text" id="Documento" name="Documento" >
                </div>
                <div>
                    <label for="Celular">Celular:</label>
                    <input type="text" id="Celular" name="Celular" >
                </div>
                <div>
                    <label for="Correo">Correo:</label>
                    <input type="text" id="Correo" name="Correo" >
                </div>

                <label> Id Curso </label>
                <select  name="curso" class="form-control">

                <option value="">Elige</option>
                <?php
                            foreach($usuarios as $filtro){
                                ?>
                                <option><?php echo $filtro['Id']?>-<?php echo $filtro['Grado']?>
                            </option>
                                <?php
                            }
                                        ?>
                </select><br>

                <input type="submit" name="btn_guardar"  id="actualizar" value="Guardar">

<!-- Controlador para realizar la funcion de agregar -->
<?php
        include("../modelo/conexioncrud.php");
        if(isset($_POST['btn_guardar']))
                    {
                        $nombre = $_POST['Nombre'];
                        $tipo = $_POST['Tipo_Documento'];
                        $documento = $_POST['Documento']; 
                        $celular = $_POST['Celular'];
                        $Correo = $_POST['Correo'];
                        $idCurso = $_POST['curso']; 
                        
                        if($nombre=="" ||  $tipo=="" || $documento=="" || $celular=="" || $Correo==""|| $idCurso=="")

                    {
                    echo "<script> alert('Todos los campos son obligatorios')
                    location.href = '../vistaProfesor/addstudent.php'; </script>";
                    }
                    else{
                        $query = mysqli_query($conectar, "INSERT INTO aprendices(Nombre, Tipo_Documento, Documento, Celular, Correo, Id_Cursos) 
                        values ('$nombre', ' $tipo',' $documento', ' $celular', '$Correo', '$idCurso')");
                        
                        if($query){
                            echo"<script> alert('Registro Exitoso')
                            location.href = '../vistaProfesor/estudiante.php';</script>";
                        }
                    }
                }
            ?>
    </form>
</div>



    </body>

</html>