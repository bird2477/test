<?php
date_default_timezone_set("Asia/Bangkok");
include '../../../../config/database.php';


$checksheet=$_POST['checksheet'];
$status=$_POST['status'];
$subproductionlineid=$_POST['subproductionlineid'];
$key=$_POST['key'];
$val=$_POST['val'];
$date=  date('Y-m-d H:i:s');
$query="INSERT INTO `timestamp`(`checksheetID`, `subproductionlineID`, `employeeID`, `datetime`, `status`) VALUES "
                                 . "('$checksheet','$subproductionlineid','$val','$date','$status')";

                         mysqli_query($connection, $query);