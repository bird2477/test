<?php
header('Content-Type: text/html; charset=utf-8');
include '../../../../config/database.php';
$name = $_POST['name'];
$lastname = $_POST['lastname'];
$username = $_POST['username'];
$password = $_POST['password'];
$privilege = $_POST['privilege'];
$employeeID = $_POST['employeeID'];
$sex = $_POST['sex'];

$query = "INSERT INTO `users`(`id`,`employeeID` , `name`, `lastname`, `username`, `password`, `privilege`, `image`,`sex`) "
        . "VALUES (null,'$employeeID'  , '$name','$lastname','$username','$password','$privilege','','$sex')";

if(mysqli_query($connection, $query)){
    echo '1';
}
?>