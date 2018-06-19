<?php
include '../../../../config/database.php';
$partcode=$_POST['partcode'];
$partname=$_POST['partname'];
$productioncode=$_POST['productioncode'];

$query="INSERT INTO `routing`(`id`, `productioncode`, `partcode`, `partname`) VALUES "
                            . "(null,'$productioncode','$partcode','$partname')";

                
if(mysqli_query($connection, $query)){
  $id=  mysqli_insert_id($connection);
  echo './views/routing/views/subrouting.php?id='.$id.'&productioncode='.$productioncode.'&partname='.$partname.'&partcode='.$partcode;
    
}