<?php
include_once '../modelo/conexion.php';
$objeto = new conexion();
$conexion = $objeto->Conectar();

$consulta = "SELECT * FROM aprendices";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$usuarios = $resultado->fetchAll(PDO::FETCH_ASSOC);


// Consulta para obtener los datos de la tabla "Id_Cursos"
$consultaCursos = "SELECT * FROM cursos";
$resultadoCursos = $conexion->prepare($consultaCursos);
$resultadoCursos->execute();
$cursos = $resultadoCursos->fetchAll(PDO::FETCH_ASSOC);


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
        <h1 id="inicio">Listado de Estudiantes</h1>

        <a href="addstudent.php"><i class="fa-solid fa-user-plus addbutton" id="add"></i></a>
        <br><br>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Tipo_Documento</th>
                    <th scope="col">Documento</th>
                    <th scope="col">Celular</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Id_Grado</th>       
                    <th scope="col">Grado</th>                                 
                    <th scope="col">Editar</th>
                    <th scope="col">Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($usuarios as $filtro){
                    
            // Obtener el nombre del curso correspondiente al ID de curso en la tabla de "cursos"
            include("../modelo/conexioncrud.php");
            $queryCurso = mysqli_query($conectar, "SELECT Grado FROM cursos WHERE Id = '{$filtro['Id_Cursos']}'");
            $nombreCurso = mysqli_fetch_assoc($queryCurso)['Grado'];
                ?>
                <tr>
                    <td><?php echo $filtro['Id']?></td>
                    <td><?php echo $filtro['Nombre']?></td>
                    <td><?php echo $filtro['Tipo_Documento']?></td>
                    <td><?php echo $filtro['Documento']?></td>
                    <td><?php echo $filtro['Celular']?></td>
                    <td><?php echo $filtro['Correo']?></td>
                    <td><?php echo $filtro['Id_Cursos']?></td>
                    <td><?php echo $nombreCurso?></td>
                    <td><a href="#"><i class="fa-solid fa-pen-to-square editButton" id="editButton"></i></a></td>
                    <td><a href="#"><i class="fa-sharp fa-solid fa-trash deleteButton" id="deletebutton"></i></a></td>
                    
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <!--Modal editar-->
    <div id="modal" class="modal">
        <div class="modal-content">
            <h2>Editar</h2>
            <form action="../controlador/edit.php" id="editForm" method="post">
                <input type="hidden" name="id" id="update_id">
                <!-- Campos del formulario de edición -->

                <div>
                    <label for="Nombre">Nombre:</label>
                    <input type="text" id="Nombre" name="Nombre" value="<?php echo $filtro['Nombre']; ?>">
                </div>
                <div>
                <label for="Tipo_Documento">Tipo_Documento:</label>
                <select id="Tipo_Documento" name="Tipo_Documento">
                    
                    
                    <option value="">Elige</option>
                    <option value="CC">CC</option>
                    <option value="TI">TI</option>
                    <?php
                    $tiposDocumentos = array_unique(array_column($usuarios, 'Tipo_Documento'));
                    foreach ($tiposDocumentos as $tipoDocumento) {
                        ?>
                        <option value="<?php echo $tipoDocumento; ?>" <?php echo $tipoDocumento == $filtro['Tipo_Documento'] ? 'selected' : ''; ?>><?php echo $tipoDocumento; ?></option>
                        <?php
                    }
                    ?>

                </select>
                </div>
                <div>
                    <label for="Documento">Documento:</label>
                    <input type="text" id="Documento" name="Documento" value="<?php echo $filtro['Documento']; ?>">
                </div>
                <div>
                    <label for="Celular">Celular:</label>
                    <input type="text" id="Celular" name="Celular" value="<?php echo $filtro['Celular']; ?>">
                </div>
                <div>
                    <label for="Correo">Correo:</label>
                    <input type="text" id="Correo" name="Correo" value="<?php echo $filtro['Correo']; ?>">
                </div>
                <div>
                <label for="Id_Cursos">Id_Cursos:</label>
                <select name="Id_Cursos" class="form-control">
                    <option value="">Elige</option>
                    <?php
                    foreach ($cursos as $curso) {
                        $idCurso = $curso['Id'];
                        $nombreCurso = $curso['Grado'];
                        ?>
                        <option value="<?php echo $idCurso; ?>"><?php echo $idCurso; ?> - <?php echo $nombreCurso; ?></option>
                    <?php
                    }
                    ?>
                </select>

                </div>
                <button id="actualizar" type="submit">Actualizar</button>
                <button type="button"  id="cerrarmodal">Cerrar</button>
            </form>
        </div>
    </div>



    <!--Modal Eliminar-->
    <div class="modale" id="modale">
      <div class="modale-content">
        <h2>Confirmar Eliminación</h2>
        <p>¿Estás seguro de que deseas eliminar este registro?</p>
        <form action="../controlador/delete.php" id="" method="post">
          <input type="hidden" name="id" id="delete_id" value="<?php echo $filtro['Id']; ?>">
          <button id="confirm-delete">Eliminar</button>
          <button type="button" id="no-delete">Cancelar</button>
        </form>
      </div>
    </div>





    <script>
    $('.editButton').on('click', function() {
        // Obtener los datos de la fila seleccionada
        $tr = $(this).closest('tr');
        var datos = $tr.children("td").map(function() {
            return $(this).text();
        });

        // Rellenar los campos del formulario de edición con los datos obtenidos
        $('#update_id').val(datos[0]);
        $('#Nombre').val(datos[1]);
        $('#Tipo_Documento').val(datos[2]);
        $('#Documento').val(datos[3]);
        $('#Celular').val(datos[4]);
        $('#Correo').val(datos[5]);
        $('#Id_Cursos').val(datos[6]);


        // Abrir el modal de edición
        $('#modal').css('display', 'block');

        $('#cerrarmodal').on('click', function() {
            // Cerrar el modal
            $('#modal').css('display', 'none');
        });

    });
    </script>


<!-- Eliminar Script -->
    <script>
      $('.deleteButton').on('click' ,function() {
        $tr=$(this).closest('tr');
        var datos=$tr.children("td").map(function(){
          return $(this).text();
          });
          $('#Id').val(datos['0']);

          //Abrir modal
          $('#modale').css('display', 'block');

        // Cerrar el modal
            $('#no-delete').on('click', function() {
        $('#modale').css('display', 'none');
      });

      })
    </script>

</body>

</html>