<?php
session_start();

// Destruir la sesión y eliminar todas las variables de sesión
session_destroy();

// Redirigir al usuario a la página de inicio de sesión o a cualquier otra página que desees después de cerrar sesión
header("Location: Login.php");
exit;
?>