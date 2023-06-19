<?php

include_once("../modelo/coneedt.php");
$Id= $_POST['id'];
$Nombre= $_POST['Nombre'];
$Tipo_Documento = $_POST['Tipo_Documento']; 
$Documento = $_POST['Documento']; 
$Celular = $_POST['Celular'];
$Correo = $_POST['Correo'];

$sentencia= $bd->prepare("UPDATE aprendices SET Nombre= ?, Tipo_Documento= ?, Documento= ?, Celular= ?, Correo= ? WHERE Id= ?");
$resultado= $sentencia->execute([$Nombre,$Tipo_Documento,$Documento,$Celular,$Correo,$Id]);


if($resultado){
    echo "<script> alert('Edicion Exitosa') 
    location.href= '../vistaProfesor/estudiante.php';</script>";
} else{
    return "Error";
}

?>