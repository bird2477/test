<?php
include '../../../../config/database.php';
$id=$_POST['id'];
$query="UPDATE `checksheet` SET   `status` = '1' WHERE `id` ='$id'";
if(mysqli_query($connection, $query)){
   echo 1;
}