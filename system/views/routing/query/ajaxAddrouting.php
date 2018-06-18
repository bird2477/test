<?php
include '../../../../config/database.php';
$code=$_POST['code'];
$name=$_POST['name'];
$productionline=$_POST['productionline'];

$query="INSERT INTO `routing`(`id`, `code`, `name`, `productionline`) VALUES"
                            . " (null,'$code','$name','$productionline')";

                
if(mysqli_query($connection, $query)){
  $id=  mysqli_insert_id($connection);
  echo './views/routing/views/subrouting.php?id='.$id.'&productionline='.$productionline.'&code='.$code.'&name='.$name;
    
}