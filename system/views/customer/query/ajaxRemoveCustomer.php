<?php
include '../../../../config/database.php';
$id=$_POST['id'];

$query="DELETE FROM `customer` WHERE `id` ='$id'";

if(mysqli_query($connection, $query)){
    echo '1';
}