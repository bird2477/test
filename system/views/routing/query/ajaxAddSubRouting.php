<?php
include '../../../../config/database.php';
$routing=$_POST['routing'];
$subproductiononline=$_POST['subproductiononline'];

$query="INSERT INTO `subrouting`(`id`, `routing`, `subproductiononline`) VALUES "
        . "(null,'$routing','$subproductiononline')";

                
if(mysqli_query($connection, $query)){
    echo '1';
    
}