<?php
include '../../../../config/database.php';
$subproductionlineID=$_GET['subproductionlineID'];
$checksheetId=$_GET['checksheetId'];
$query="SELECT  `checksheet`.`date`,`subchecksheet`.`target`,`subchecksheet`.`actual_total`,`subchecksheet`.`free_total`,`subchecksheet`.`reject_total`
FROM  `checksheet` 
INNER JOIN `subchecksheet` ON  `subchecksheet`.`checksheet`=`checksheet`.`id` WHERE  `subchecksheet`.`checksheet` ='$checksheetId' and `subchecksheet`.`subproductionlineID` ='$subproductionlineID'";
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
    <thead>
        <tr class="frame">
            <th class="frame">Date</th>
            <th class="frame">Target</th>
            <th class="frame">Actual</th>
            <th class="frame">Free shot</th>
            <th class="frame">Reject</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $result=  mysqli_query($connection, $query);
        while ($row = mysqli_fetch_array($result)) {
          ?>
        <tr class="frame">
            <td class="frame"><?php echo $row['date']; ?></td>
            <td class="frame"><?php echo $row['target']; ?></td>
            <td class="frame"><?php echo $row['actual_total']; ?></td>
            <td class="frame"><?php echo $row['free_total']; ?></td>
            <td class="frame"><?php echo $row['reject_total']; ?></td>
        </tr>
       <?php  
        } 
       ?>
        <tr>
            <td colspan="3" style="text-align: right;">ผู้คุมเครื่อง:
                <?php
                $query="SELECT  `employeeID` FROM `timestamp` WHERE `checksheetID` = '$checksheetId' and `subproductionlineID` ='$subproductionlineID'";
                $result=  mysqli_query($connection, $query);
                $row=  mysqli_fetch_array($result);
                $employeeID=$row['employeeID'];
                $query="SELECT * FROM `users` WHERE `employeeID` like '$employeeID'";
                $result=  mysqli_query($connection, $query);
                $row=  mysqli_fetch_array($result);
                echo $row['name'];
                ?>
            </td>
            <td colspan="2" style="text-align: left;"></td>
        </tr>
    </tbody>
</table>