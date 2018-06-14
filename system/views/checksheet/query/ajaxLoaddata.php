<?php
include '../../../../config/database.php';

$checksheetId=$_POST['checksheetId'];

$query="SELECT * FROM `subchecksheet` WHERE `checksheet` ='$checksheetId'";
$result=  mysqli_query($connection, $query);
$array=array();
$cou=0;
while ($row = mysqli_fetch_assoc($result)) {
    $subproductionlineID=$row['subproductionlineID'];
    $query="SELECT * FROM `subproductionline` WHERE `id` like '$subproductionlineID'";
    $result1=  mysqli_query($connection, $query);
    $row1=  mysqli_fetch_array($result1);
    $data= array();
    $data['actual'.$subproductionlineID]=$row1['actual_total'];
    $array[$cou]=$data;
    $cou++;
    $actual_total=$row1['actual_total'];
    $free_total=$row1['free_total'];
    $reject_total=$row1['reject_total'];
   
}
echo json_encode($array);
 $query="UPDATE `subchecksheet` SET  `actual_total`='$actual_total',`free_total`='$free_total',`reject_total`='$reject_total' WHERE `checksheet` ='$checksheetId'";
    mysqli_query($connection, $query);
 