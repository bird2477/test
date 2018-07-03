<?php
date_default_timezone_set("Asia/Bangkok");
include '../../../../config/database.php';

$target=$_POST['target'];
$lotno=$_POST['lotno'];

$query="SELECT * FROM `routing` WHERE `lotno` LIKE '$lotno'";
$result=  mysqli_query($connection, $query);
$row=  mysqli_fetch_array($result);
$routing=$row['id'];

$date = date('Y-m-d');
$query="INSERT INTO `checksheet`(`id`, `date` ,`routing`, `traget`, `status`) VALUES"
        . " (null,'$date','$routing','$target','0')";
mysqli_query($connection, $query);
$checksheetId=  mysqli_insert_id($connection);


$query = "SELECT * FROM `subrouting` WHERE `routing` ='$routing' ORDER BY `step` ASC";
$result =  mysqli_query($connection, $query);

while ($row1 = mysqli_fetch_array($result)) {
    $step=$row1['step'];
    $query="INSERT INTO `subchecksheet`(`id`, `checksheet`, `subproductionlineID`, `target`, `actual_total`, `free_total`, `reject_total`, `speed`, `step`) VALUES "
                                    . "(null,'$checksheetId','0','$target','0','0','0','0','$step')";
    mysqli_query($connection, $query);
}
echo $checksheetId;

