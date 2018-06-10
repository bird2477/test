<?php
include '../../../../config/database.php';
$username=$_POST['username'];
$query = "SELECT * FROM `users` WHERE `username` like '$username'";
$result=   mysqli_query($connection, $query);
$num=  mysqli_num_rows($result);
echo $num;