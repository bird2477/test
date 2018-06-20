<?php

include '../../../../config/database.php';
$checksheetId = $_POST['checksheetId'];
$query = "UPDATE `checksheet` SET `status`='1' WHERE `id` ='$checksheetId'";
mysqli_query($connection, $query);


$query = "SELECT  `subproductionline`.`speed` , `subchecksheet`.`subproductionlineID`, `subproductionline`.`name`, `subchecksheet`.`target`, `subproductionline`.`actual_total`, `subproductionline`.`free_total`, `subproductionline`.`reject_total`
FROM `subchecksheet`
INNER JOIN `subproductionline` ON  `subchecksheet`.`subproductionlineID`= `subproductionline`.`id` WHERE subchecksheet.checksheet ='$checksheetId'";


$result = mysqli_query($connection, $query);
while ($row = mysqli_fetch_array($result)) {
    $subproductionlineID = $row['subproductionlineID'];
    $query="SELECT * FROM `subproductionline` WHERE `id` ='$subproductionlineID'";
    $result1=  mysqli_query($connection, $query);
    $row1=  mysqli_fetch_array($result1);
    $speed=$row['speed'];
    $reject_total=$row1['reject_total'];
    $free_total=$row1['free_total'];
    $actual_total=$row1['actual_total'];
    $target=$row1['target'];
    $query=" UPDATE `subchecksheet` SET  `target` ='$target',`actual_total`='$actual_total',`free_total`='$free_total',`reject_total`='$reject_total',`speed`='$speed'   WHERE      `checksheet` ='$checksheetId' and `subproductionlineID` ='$subproductionlineID'";
 
    mysqli_query($connection, $query);
    $query = "UPDATE `subproductionline` SET  `speed`='0',`reject_total`='0' ,`free_total`='0' ,`actual_total`='0' ,`target`  ='0' ,`status`='0' WHERE `id` ='$subproductionlineID'";
    mysqli_query($connection, $query);
}