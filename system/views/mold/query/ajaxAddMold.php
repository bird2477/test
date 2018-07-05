<?php
include '../../../../config/database.php';
$customer=$_POST['customer'];
$moldcode=$_POST['moldcode'];
$productioncode=$_POST['productioncode'];
$partcode=$_POST['partcode'];
$partname=$_POST['partname'];

$query="INSERT INTO `mold`(`id`, `moldcode`, `customer`, `productioncode`,`partcode`,`partname`) VALUES "
        . "(null,'$moldcode','$customer','$productioncode','$partcode','$partname')";
if(mysqli_query($connection, $query)){
    echo '1';
}
