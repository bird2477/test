<?php
include '../../../../config/database.php';
$id=$_POST['id'];
$key=$_POST['key'];
$val=$_POST['val'];

$query="UPDATE `subproductionline` SET `$key`='$val'   WHERE `id` ='$id'";

if(mysqli_query($connection, $query)){
    echo '1';
}