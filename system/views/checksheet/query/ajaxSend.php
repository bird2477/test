<?php

include '../../../../config/database.php';
$checksheetId = $_POST['checksheetId'];
$query = "UPDATE `checksheet` SET `status`='1' WHERE `id` ='$checksheetId'";
mysqli_query($connection, $query);
$query = "SELECT  `subproductionline`.`speed` , `subchecksheet`.`subproductionlineID`, `subproductionline`.`name`, `subchecksheet`.`target`, `subproductionline`.`actual_total`, `subproductionline`.`free_total`, `subproductionline`.`reject_total`
FROM `subchecksheet`
INNER JOIN `subproductionline` ON  `subchecksheet`.`subproductionlineID`= `subproductionline`.`id` WHERE subchecksheet.checksheet ='$checksheetId' ORDER BY `subchecksheet`. `step` ASC";
$result = mysqli_query($connection, $query);
while ($row = mysqli_fetch_array($result)) {
    $subproductionlineID = $row['subproductionlineID'];
    mysqli_query($connection, $query);
    $query = "UPDATE `subproductionline` SET  `speed`='0',`reject_total`='0' ,`free_total`='0' ,`actual_total`='0' ,`target`  ='0' ,`status`='0' WHERE `id` ='$subproductionlineID'";
    mysqli_query($connection, $query);
}
$query = "SELECT * FROM `routing` WHERE `id` =(SELECT `routing` FROM `checksheet` WHERE `id` ='$checksheetId')";
$re = mysqli_query($connection, $query);
$row = mysqli_fetch_array($re);
$routing=$row['id'];
$query="SELECT * FROM `subchecksheet` WHERE `checksheet` ='$checksheetId'";

$result=  mysqli_query($connection, $query);
while ($row1 = mysqli_fetch_array($result)) {
    $subproductionlineID = $row1['subproductionlineID'];
    $id = $row1['id'];
    $query="SELECT * FROM `timestamp` WHERE `subchecksheetID` ='$id' ";
    
    $r=  mysqli_query($connection, $query);
    $actual=0;
    $free=0;
    $actual_total=0;
    $reject=0;
    while ($row2 = mysqli_fetch_array($r)) {
        $actual =$actual+ floatval($row2['actual']);
        $free =$free+ floatval($row2['free']);
        $reject =$reject+ floatval($row2['reject']);
    }
    $actual_total = $free+$reject+$actual;
    $query="UPDATE `subchecksheet` SET `actual_total` ='$actual' ,`free_total` ='$free' ,`reject_total` ='$reject'  WHERE `id` ='$id'";
   
    mysqli_query($connection, $query);
    
}

$routing_actual=$actual;
$query="SELECT * FROM `routing` WHERE `id` ='$routing'";

$re=  mysqli_query($connection, $query);
$row=  mysqli_fetch_array($re);
$routing_actual = $routing_actual + $row['actual'];


$query="UPDATE `routing` SET `actual`='$routing_actual' WHERE `id` ='$routing'";
mysqli_query($connection, $query);