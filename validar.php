<?php
$usuario=$_POST['usuario'];
$contraseña=$_POST['contraseña'];
session_start();
$_SESSION['usuario']=$usuario;

include('db.php');

$consulta="SELECT*FROM usuario where Usuario='$usuario' and Contraseña='$contraseña'";
$resultado=mysqli_query($conexion,$consulta);

$filas=mysqli_fetch_array($resultado);

if (isset($filas['Id_rol'])) {
    if ($filas['Id_rol'] == 1) {
        // Redirigir al administrador a admin.php
        header("Location: vistaProfesor/index.php");
        exit;
    } elseif ($filas['Id_rol'] == 2) {
        // Redirigir al cliente a cliente.php
        header("Location: vistaEstudiante/consulta.php");
        exit;
    }}
else{
    ?>
    <?php
    include("Login.php");
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
        icon: 'error',
        title: 'Usuario o contraseña incorrectos',
        text: '¡Intentalo nuevemente!',
        confirmButtonColor: '#14ae54'
        })
    </script>
    <?php
}
mysqli_free_result($resultado);
mysqli_close($conexion);
