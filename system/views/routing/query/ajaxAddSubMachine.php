<?php
include '../../../../config/database.php';
$productionline=$_POST['productionline'];
$name=$_POST['name'];

$query ="INSERT INTO `subproductionline`(`id`, `productionline`, `name`) VALUES "
        . "                             (null,'$productionline','$name')";

if(mysqli_query($connection, $query)){
    echo '1';
}