<?php
include '../../../../config/database.php';
$step=$_POST['step'];               
$customer=$_POST['customer'];               
$mold=$_POST['moldcode'];               
$routing=$_POST['routing'];
$query="INSERT INTO `listsubproductionline`(`id`, `json`) VALUES (null,'')";
$result=mysqli_query($connection, $query);
$listsubproductionline_id  = mysqli_insert_id($connection);
$query="INSERT INTO `subrouting`(`id`, `routing`, `listsubproductionline_id`, `mold`, `step`) VALUES "
                                . "(null,'$routing','$listsubproductionline_id','$mold','$step')";
if(mysqli_query($connection, $query)){
    echo '1';
    
}?>
