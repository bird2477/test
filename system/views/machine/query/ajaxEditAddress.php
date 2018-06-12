<?php
include '../../../../config/database.php';
$id=$_POST['id'];
$colum=$_POST['colum'];
$val=$_POST['val'];
$query="UPDATE `subproductionline` SET  `$colum`='$val'      WHERE  `id` ='$id'";
if(mysqli_query($connection, $query)){
   echo 1;
}