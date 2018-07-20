<?php
session_start();
include '../../../../config/database.php';
$val=$_POST['username'];
$query="SELECT * FROM `users` WHERE `username` like '$val'";
$re=  mysqli_query($connection, $query);
$r=  mysqli_num_rows($re);
echo $r;