<?php
include '../../../../config/database.php';
$taxno=$_POST['taxno'];
$name=$_POST['name'];
$address=$_POST['address'];

$query="INSERT INTO `customer`(`id`, `taxno`, `name`, `address`) VALUES "
                                . "(null,'$taxno','$name','$address')";
if(mysqli_query($connection, $query)){
    echo '1';
}
