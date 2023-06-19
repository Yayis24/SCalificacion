<?php
        include("../modelo/coneedt.php");
        if(isset($_POST['addbutton']))
                    {
                        $id= $_POST['Id'];
                        $nombre = $_POST['Nombre']; 
                        $tipodocumento = $_POST['Tipo_Documento']; 
                        $documento = $_POST['Documento'];
                        $Correo = $_POST['Correo']; 
                        $Celular = $_POST['Celular']; 

                        
                        if($id=="" ||  $nombre=="" || $tipodocumento=="" || $documento=="" || $Correo=="" || $Celular=="")

                    {
                    echo "<script> alert('Todos los campos son obligatorios')
                    location.href = '../vistaProfesor/estudiante.php'; </script>";
                    }
                    else{
                        $query = mysqli_query($conectar, "INSERT INTO aprendices(Id, Nombre, Tipo_Documento, Correo, Celular) 
                        values ('$id', ' $nombre',' $tipodocumento', ' $documento', '$Correo', '$Celular')");
                        
                        if($query){
                            echo"<script> alert('Registro Exitoso')
                            location.href = '../vistaProfesor/estudiante.php';</script>";
                        }
                    }
                }
                        ?>