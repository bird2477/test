<?php
include '../../../../config/database.php';

$targete=$_POST['target'];
$lotno=$_POST['lotno'];
$deadline=$_POST['deadline'];

$query="INSERT INTO `routing`(`id`, `target`, `lotno`,`deadline`) VALUES "
                             . "(null,'$targete','$lotno','$deadline')";

                
 if(mysqli_query($connection, $query)){
  $id=  mysqli_insert_id($connection);
  echo './views/routing/views/subrouting.php?id='.$id.'&lotno='.$lotno.'&target='.$targete;
    
}