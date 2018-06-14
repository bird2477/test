<?php

include '../../../../config/database.php';
$checksheetId = $_POST['checksheetId'];
$query = "UPDATE `checksheet` SET `status`='1' WHERE `id` ='$checksheetId'";
mysqli_query($connection, $query);


$query = "SELECT `subchecksheet`.`subproductionlineID`, `subproductionline`.`name`, `subchecksheet`.`target`, `subproductionline`.`actual_total`, `subproductionline`.`free_total`, `subproductionline`.`reject_total`
FROM `subchecksheet`
INNER JOIN `subproductionline` ON  `subchecksheet`.`subproductionlineID`= `subproductionline`.`id` WHERE subchecksheet.checksheet ='$checksheetId'";


$result = mysqli_query($connection, $query);
while ($row = mysqli_fetch_array($result)) {
    $subproductionlineID = $row['subproductionlineID'];
    $target = $row['target'];
    $query = "UPDATE `subproductionline` SET   `target`  ='0' ,`status`='0' WHERE `id` ='$subproductionlineID'";
    mysqli_query($connection, $query);
}