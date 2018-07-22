<?php
include '../../../../config/database.php';
$id=$_POST['id'];
$query="UPDATE `checksheet` SET   `status` = '2' WHERE `id` ='$id'";
if(mysqli_query($connection, $query)){
   echo 1;
}