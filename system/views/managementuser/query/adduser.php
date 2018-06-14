<?php
include '../../../../config/database.php';

$name = $_POST['name'];
$lastname = $_POST['lastname'];
$username = $_POST['username'];
$password = $_POST['password'];
$privilege = $_POST['privilege'];
$employeeID = $_POST['employeeID'];

$query = "INSERT INTO `users`(`id`,`employeeID` , `name`, `lastname`, `username`, `password`, `privilege`, `image`) "
        . "VALUES (null,'$employeeID'  , '$name','$lastname','$username','$password','$privilege','')";

mysqli_query($connection, $query);
?>
<script >
    window.location.replace("../../../index.php?fragment=user&component=listuser");
</script>
