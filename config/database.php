<?php

$servername = "localhost";
$user = "root";
$pass = "";
$database = "realtime";
$connection= mysqli_connect ($servername, $user, $pass, $database);
mysqli_query($connection,"SET NAMES utf8");