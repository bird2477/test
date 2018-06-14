<?php
date_default_timezone_set("Asia/Bangkok");
include '../../../../config/database.php';
$productionline=$_POST['productionline'];
$name=$_POST['name'];
$code=$_POST['code'];
$target=$_POST['target'];
$query="SELECT `id` FROM `routing` WHERE `code` like '$code' and `name` like '$name' and `productionline` ='$productionline'";
$result=  mysqli_query($connection, $query);
$row=  mysqli_fetch_array($result);
$routing=$row['id'];
$target=$_POST['target'];
$date = date('Y-m-d');
$query="INSERT INTO `checksheet`(`id`, `date`, `routing`, `traget`, `status`) VALUES"
        . " (null,'$date','$routing','$target','0')";
mysqli_query($connection, $query);
$checksheetId=  mysqli_insert_id($connection);


$query = "SELECT * FROM `subrouting` WHERE `routing` ='$routing'";
$result =  mysqli_query($connection, $query);

while ($row1 = mysqli_fetch_array($result)) {
    $subproductionlineID=$row1['subproductiononline'];
    $query="INSERT INTO `subchecksheet`(`id`, `checksheet`, `subproductionlineID`, `target`, `actual_total`, `free_total`, `reject_total`) VALUES"
                                    . " (null,'$checksheetId','$subproductionlineID','$target','0','0','')";
                            mysqli_query($connection, $query);
}
echo $checksheetId;

