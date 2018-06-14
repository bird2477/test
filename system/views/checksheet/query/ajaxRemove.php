<?php
include '../../../../config/database.php';
$id=$_POST['id'];

$query="DELETE FROM `checksheet` WHERE `id` = '$id'";
mysqli_query($connection, $query);

$query="DELETE FROM `timestamp` WHERE `checksheetID='$id'";
mysqli_query($connection, $query);

$query="DELETE FROM `subchecksheet` WHERE `checksheet` ='$id'";
if(mysqli_query($connection, $query)){
   echo 1;
}
