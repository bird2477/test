<?php
include '../../../../config/database.php';
$name=$_POST['name'];

$query="INSERT INTO `productionline`(`id`, `machine`) VALUES (null,'$name')";
if(mysqli_query($connection, $query)){
   $query="SELECT * FROM `productionline` WHERE 1 ORDER BY `id` DESC  LIMIT 0,1";
   $result=  mysqli_query($connection, $query);
   $row=  mysqli_fetch_array($result);
   
   echo $row['id'];
   
}