<?php

include_once("../modelo/coneedt.php");
$id=$_POST['id'];

$sentencia= $bd->prepare("DELETE FROM aprendices WHERE Id=:id;");
$sentencia->bindParam(':id',$id);

if($sentencia->execute()){
    echo "<script> alert ('Eliminacion exitosa') 
    location.href='../vistaProfesor/estudiante.php'; </script>";

} else{
    return "Error";
}


?>