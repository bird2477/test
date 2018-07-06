<?php
include '../../../../config/database.php';
$customer=$_POST['customer'];

$productioncode=$_POST['productioncode'];
$partcode=$_POST['partcode'];
$partname=$_POST['partname'];

$query="INSERT INTO `mold`(`id`, `customer`, `productioncode`,`partcode`,`partname`) VALUES "
        . "(null,'$customer','$productioncode','$partcode','$partname')";
if(mysqli_query($connection, $query)){
    echo '1';
}
