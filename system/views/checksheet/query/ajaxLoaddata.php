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
    $data['actual'.$row['step']]=$row1['actual_total'] ==NULL? "0":$row1['actual_total']-$row1['free_total']-$row1['reject_total'];
    $data['free'.$row['step']]= $row1['free_total'] ==NULL ? "0":$row1['free_total'];
    $data['reject'.$row['step']]=$row1['reject_total'] ==NULL?"0":$row1['reject_total'];
    $data['total'.$row['step']]=$row1['actual_total'] ==NULL? "0":$row1['actual_total'];
    $array[$cou]=$data;
    $cou++;
}
echo json_encode($array);

 