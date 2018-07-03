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
 $query="UPDATE `subproductionline` SET `status` ='0' ,`reject_total` ='0' ,`free_total` ='0' ,`actual_total` ='0' WHERE `id` ='$subproductionlineID'";
 mysqli_query($connection, $query);
 
 $query="UPDATE `subproductionline` SET `status` ='1' ,`target` ='$target'WHERE `id` ='$option'";
 mysqli_query($connection, $query);
 
 $query="UPDATE `subchecksheet` SET  `subproductionlineID` ='$option'    WHERE `step` ='$step' and `id` ='$subchecksheet'";
 mysqli_query($connection, $query);