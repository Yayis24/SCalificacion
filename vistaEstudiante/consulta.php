<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image" href="../IMG/lo429356.png" >
    <script src="https://kit.fontawesome.com/1ade5e208e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/tabla.css">
    <link rel="stylesheet" href="../css/consulta.css">


    <title>Inicio</title>
</head>
<body>

<div class="navegacion">
        <ul>

            <li>

                <a href="consulta.php" class="seleccionado">
                    <span class="icono">
                    <i class="fa-solid fa-magnifying-glass"></i>                    
                </span>
                    <span class="titulo">Consulta</span>
                </a>
            </li>

            <li>

                <a href="reporte.php">
                    <span class="icono">
                    <i class="fa-solid fa-file-arrow-down"></i>
                                    </span>
                    <span class="titulo">Reporte</span>
                </a>
            </li>

            <li>
                <a href="../logout.php" id="alumno"> 
                        <span class="icono">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </span>
                        <span class="titulo">Cerrar Sesion</span>
                    </a>
            </li>
        </ul>
    </div>


<div class="contenido">

<h1 id="inicio">Consulta tus notas</h1>

<div id="container" style="text-align: center;">
    <form action="" method="post" >
    <table>
        <tr>
            <td>
                <label>Joven estudiante, digita el numero de documento</label>
                <input type="text" name="ConsultaDocumento" class="form-control">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input id="buton" type="submit" name="btn_consultar" value="Consultar" class="btn btn-info">
            </td>
        </tr>
        <td colspan="2"></td>
    </table>

</form>
    <?php
    
    include_once "../modelo/consult.php";
    if(isset($_POST['btn_consultar']))
    {
        $documento = $_POST['ConsultaDocumento'];
        $existe = 0;
    
        if($documento=="")
        {
            echo "<script> alert('Campo Obligatorio')
            location.href = '../vistaEstudiante/consulta.php';</script>";
        }
        else{
            $resultado = mysqli_query($conectar, "SELECT c.*, c.Id, c.Id_Profesor, c.Id_Alumno, c.Id_Materia, c.Promedio, p.Docente AS NombreProfe,
                                                    m.Nombre AS MateriaName
                                                    FROM calificacion c
                                                    INNER JOIN profesor p ON c.Id_Profesor = p.Id
                                                    INNER JOIN aprendices a ON c.Id_Alumno = a.Id
                                                    INNER JOIN materia m ON c.Id_Materia = m.Id
                                                    WHERE Documento = '$documento'");
    
            while($consulta = mysqli_fetch_array($resultado))
            {
                echo "
                
                <table class='table'>
                <thead class='thead-dark'>
                <tr>
                <td><center><b>Documento</b></center></td>
                <td><center><b>Aprendiz</b></center></td>
                <td><center><b>Correo</b></center></td>
                <td><center><b>Id Cursos</b></center></td>
                </tr>
                </thead>
                <tr>
                <td><center>".$consulta['Documento']."</center></td>
                <td><center>".$consulta['Nombre']."</center></td>
                <td><center>".$consulta['Correo']."</center></td>
                <td><center>".$consulta['Id_Cursos']."</center></td>
                </tr>
                </table>";
    
                $existe++;
            }
    
            if($existe==0){
                echo "<script> alert('Numero de Documento digitado no existe en BD')
                location.href= '../vistaEstudiante/consulta.php';</script>";
            }
        }
    }
    
    ?>


</div>

</body>
</html>