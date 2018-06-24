<?php
include '../../../../config/database.php';
$routing=$_POST['routing'];
$subproductiononline=$_POST['subproductiononline'];
$mold=$_POST['mold'];

$query="INSERT INTO `subrouting`(`id`, `routing`, `subproductiononline`,`mold`) VALUES "
        . "(null,'$routing','$subproductiononline','$mold')";

                
if(mysqli_query($connection, $query)){
    echo '1';
    
}