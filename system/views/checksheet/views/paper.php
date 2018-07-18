<?php
include '../../../../config/database.php';
$subproductionlineID=$_GET['subproductionlineID'];
$checksheetId=$_GET['checksheetId'];
$query="SELECT * FROM `routing` WHERE `id` = (SELECT routing FROM `checksheet` WHERE `id` ='$checksheetId')";

$result = mysqli_query($connection, $query);
$row=  mysqli_fetch_array($result);
$deadline=$row['deadline'];
$routing_id=$row['id'];


$query="SELECT  `checksheet`.`date`,`subchecksheet`.`target`,`subchecksheet`.`actual_total`,`subchecksheet`.`free_total`,`subchecksheet`.`reject_total`,`subchecksheet`.`step`
FROM  `checksheet` 
INNER JOIN `subchecksheet` ON  `subchecksheet`.`checksheet`=`checksheet`.`id` WHERE  `subchecksheet`.`checksheet` ='$checksheetId' and `subchecksheet`.`subproductionlineID` ='$subproductionlineID'";
$result=  mysqli_query($connection, $query);
$row1= mysqli_fetch_array($result);

$step=$row1['step'];
$query="SELECT * FROM `mold` WHERE `id`=(SELECT `mold` FROM `subrouting` WHERE `routing` ='$routing_id' and `step` ='$step')";
$r=  mysqli_query($connection, $query);
$rt=  mysqli_fetch_array($r);



$query="SELECT * FROM `subproductionline` WHERE `id` = '$subproductionlineID'";
$result=  mysqli_query($connection, $query);

$row2=  mysqli_fetch_array($result);
?>
<style type="text/css">
    body,td,th {
        font-family: Tahoma;
        font-size: 11px;
    }
    table { border-collapse:collapse;}
    .frame{ border: 1px solid black;	text-align: center; }
    .rec{ color:#0066ff; }
</style> 
<table border="0" align="center"  style="width: 650px; text-align: center;" class="frame"  >
    <tr>
        <td class="frame">Production Code</td>
        <td class="frame"><?php echo $rt['productioncode']; ?></td>
        <td class="frame">Part Code</td>
        <td class="frame"><?php echo $rt['partcode']; ?></td>
        <td class="frame">วันที่ออกใบงาน</td>
        <td class="frame"><?php echo $row1['date']; ?></td>
    </tr>
    <tr>
        <td class="frame" >Part Name</td>
        <td class="frame" colspan="3"><?php echo $rt['partname']; ?></td>
        <td class="frame">วันที่ต้องการงานทั้งหมด</td>
        <td class="frame"><?php echo $deadline; ?></td>
    </tr>
    <tr>
        <td colspan="6" >&nbsp;</td>
    </tr>
    
    <?php
       $query="SELECT * FROM `users` WHERE  `privilege`='1' and `employeeID` like (SELECT `employeeID`  FROM `timestamp` WHERE `checksheetID` = '$checksheetId' and `subproductionlineID` ='$subproductionlineID'  order by `timestamp`.`id` desc  limit 0,1)";
      
        $result=  mysqli_query($connection, $query);
        $row5= mysqli_fetch_array($result);
       
        $employeeID=$row5['employeeID'];
    $query="SELECT * FROM `timestamp` WHERE `checksheetID` = '$checksheetId' and `subproductionlineID`='$subproductionlineID' and `employeeID` ='$employeeID'  ";
    $re=  mysqli_query($connection, $query);
    $actual_total=0;
    $free_total=0;
    $reject_total=0;
     while ( $row6=  mysqli_fetch_array($re)){
        $actual_total =$actual_total+$row6['actual'];
        $free_total =$free_total+$row6['free'];
        $reject_total =$reject_total+$row6['reject'];
      
    }
   
    $actual_total =$actual_total+$free_total+$reject_total;
    
    ?>
    <tr>
        <td class="frame" >Target</td>
        <td class="frame" >Actual Goods </td>
        <td class="frame" >Free Total</td>
        <td class="frame" >Reject Total</td>
        <td class="frame" colspan="2" >Operator</td>
    </tr>
     <tr>
        <td class="frame" ><?php echo $row1['target']; ?></td>
        <td class="frame" >
            
            <?php echo $actual_total; ?>
        
        
        </td>
        <td class="frame" ><?php echo $free_total; ?></td>
        <td class="frame" ><?php echo $reject_total; ?></td>
        <td class="frame" colspan="2" ><?php 
     
         echo $row5['name'];
        
        ?></td>
    </tr>
</table>