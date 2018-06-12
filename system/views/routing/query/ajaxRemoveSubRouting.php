<?php
include '../../../../config/database.php';
$id=$_POST['id'];

$query="DELETE FROM `subrouting` WHERE `id`='$id'";

if(mysqli_query($connection, $query)){
    echo '1';
}