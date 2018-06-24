<?php
include '../../../../config/database.php';
$customer=$_POST['customer'];
$moldcode=$_POST['moldcode'];
$detail=$_POST['detail'];

$query="INSERT INTO `mold`(`id`, `moldcode`, `customer`, `detail`) VALUES "
        . "(null,'$moldcode','$customer','$detail')";
if(mysqli_query($connection, $query)){
    echo '1';
}
