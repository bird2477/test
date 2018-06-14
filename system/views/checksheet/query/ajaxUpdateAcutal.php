<?php
include '../../../../config/database.php';
$key=$_POST['key'];
$val=$_POST['val'];
$subproductionlineID=$_POST['subproductionlineID'];

$query="UPDATE `subproductionline` SET   `$key`='$val'      WHERE  `id` ='$subproductionlineID'";

mysqli_query($connection, $query);