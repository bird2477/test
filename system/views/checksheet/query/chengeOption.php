<?php
 include '../../../../config/database.php';

 $option=$_POST['option'];
 $step=$_POST['step'];
 $subchecksheet=$_POST['subchecksheet'];
 

 
 $query="SELECT * FROM `subchecksheet` WHERE `id` ='$subchecksheet'";
 $result=  mysqli_query($connection, $query);
 $row= mysqli_fetch_array($result);
 $target=$row['target'];
 $subproductionlineID=$row['subproductionlineID'];
 
  $query="SELECT * FROM `timestamp` WHERE `subchecksheetID` = '$subchecksheet' and `subproductionlineID` = '$subproductionlineID'  and `status` ='1'";
  $result=mysqli_query($connection, $query);
 $row=  mysqli_num_rows($result);
 
 if($row>=1){
     echo 'กรุณายิงบาร์โค้ดออกจากระบบ';
 }else{

 $query="UPDATE `subchecksheet` SET  `subproductionlineID` ='$option'    WHERE `step` ='$step' and `id` ='$subchecksheet'";
 mysqli_query($connection, $query);
 }