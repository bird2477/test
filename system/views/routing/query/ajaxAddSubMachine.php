<?php
include '../../../../config/database.php';
$productionline=$_POST['productionline'];
$name=$_POST['name'];
$type=$_POST['type'];
$capability=$_POST['capability'];
$model=$_POST['model'];
$brandname=$_POST['brandname'];

$query ="INSERT INTO `subproductionline`(`id`, `productionline`, `name`, `type`, `capability`, `model`, `brandname`) VALUES "
                                        . "(null,'$productionline','$name','$type','$capability','$model','$brandname')";

if(mysqli_query($connection, $query)){
    echo '1';
}