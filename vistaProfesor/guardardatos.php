<?php
include("../modelo/conexioncrud.php");

if(isset($_POST['guardar']))
{

    $nfinal=$_POST['notafinal'];

    if($nfinal =="")
  
    $query = mysqli_query($conectar, "INSERT INTO calificacion (Promedio) values ('$nfinal')");
    

}
?>