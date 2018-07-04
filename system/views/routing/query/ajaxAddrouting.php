<?php
include '../../../../config/database.php';
$productioncode=$_POST['productioncode'];
$partcode=$_POST['partcode'];
$partname=$_POST['partname'];
$targete=$_POST['target'];
$lotno=$_POST['lotno'];
$deadline=$_POST['deadline'];

$query="INSERT INTO `routing`(`id`, `productioncode`, `partcode`, `partname`, `target`, `lotno`,`deadline`) VALUES "
                             . "(null,'$productioncode','$partcode','$partname','$targete','$lotno','$deadline')";

                
 if(mysqli_query($connection, $query)){
  $id=  mysqli_insert_id($connection);
  echo './views/routing/views/subrouting.php?id='.$id.'&productioncode='.$productioncode.'&partname='.$partname.'&partcode='.$partcode.'&lotno='.$lotno.'&target='.$targete;
    
}