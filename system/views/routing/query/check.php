<?php
session_start();
include '../../../../config/database.php';
$val=$_POST['name'];
$query="SELECT * FROM `routing` WHERE `lotno` like '$val' ";
$re=  mysqli_query($connection, $query);
$r=  mysqli_num_rows($re);

echo $r;