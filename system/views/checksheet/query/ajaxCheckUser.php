<?php

date_default_timezone_set("Asia/Bangkok");
include '../../../../config/database.php';
$checksheet = $_POST['checksheet'];
$subchecksheet = $_POST['subchecksheet'];
$status = $_POST['status'];
$subproductionlineid = $_POST['subproductionlineid'];
$val = $_POST['val'];
$date = date('Y-m-d H:i:s');
$query ="SELECT * FROM `users` WHERE `employeeID` like '$val'";
$r=  mysqli_query($connection, $query);
$row=  mysqli_fetch_array($r);
$num=  mysqli_num_rows($r);

if($num <=0){
   echo 'ไม่สำเร็จ';
}else{
    
if($row['privilege'] <=1){
   
   
if ($status == 1) {

    $query = "UPDATE `subproductionline` SET `status` = '1' ,`checksheetID`='$checksheet'  WHERE `id` ='$subproductionlineid'";
    mysqli_query($connection, $query);

    $query = "INSERT INTO `timestamp`(`id`, `checksheetID`, `subchecksheetID`, `subproductionlineID`, `employeeID`, `start_datetime`, `end_datetime`, `actual`, `free`, `reject`, `status`) VALUES "
            . "(null,'$checksheet','$subchecksheet','$subproductionlineid','$val','$date','','0','0','0','1')";

    mysqli_query($connection, $query);
} else {
    $query = "SELECT * FROM `subproductionline` WHERE `id` ='$subproductionlineid'";
    $re = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($re);
    $free = $row['free_total'];
    $reject = $row['reject_total'];
    $actual = $row['actual_total'] - $free - $reject;
    $query = "SELECT * FROM `timestamp` WHERE `checksheetID` ='$checksheet' and `subchecksheetID` ='$subchecksheet' and `subproductionlineID` ='$subproductionlineid' and `status` ='1'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);
    if ($row['employeeID'] == $val) {
        $query = "UPDATE `timestamp` SET `status`='0'  ,`end_datetime` ='$date' ,  `actual` ='$actual' ,`free` ='$free' ,`reject` ='$reject'   WHERE `checksheetID` ='$checksheet' and `subchecksheetID` ='$subchecksheet' and `subproductionlineID` ='$subproductionlineid' and `status` ='1'";

        mysqli_query($connection, $query);
        $query = "UPDATE `subproductionline` SET `checksheetID`='0' , `speed`='0',`reject_total`='0' ,`free_total`='0' ,`actual_total`='0' ,`status`='0' WHERE `id` ='$subproductionlineid'";
        mysqli_query($connection, $query);
         echo 'สำเร็จ';
    }else{
         echo 'ไม่สำเร็จ';
    }
}
 $query="UPDATE `subproductionline` SET  `statusUser` ='$status' WHERE `id`='$subproductionlineid'";  
 mysqli_query($connection, $query);

}else{
    echo 'ไม่สำเร็จ';
}


}
                         
                         
                         
                         
                         
                         
                         
// $query="UPDATE `subproductionline` SET  `statusUser` ='$status' WHERE `id`='$subproductionlineid'";  
 //mysqli_query($connection, $query);