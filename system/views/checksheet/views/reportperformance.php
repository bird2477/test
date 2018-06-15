<?php include '../../../../config/database.php'; ?>
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
            <th class="frame">ผู้ปฏิบัติงาน</th>
            <th class="frame">ชืองาน</th>
            <th class="frame">เครื่องจักร</th>
            <th class="frame">เวลาเริ่ม</th>
            <th class="frame">เวลาหยุด</th>

        </tr>
    </thead>
    <tbody>
        <?php
        $checksheet = $_GET['checksheet'];
        $query = "SELECT * FROM `subchecksheet` WHERE `checksheet` ='$checksheet' ";
        $result = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_array($result)) {
            
            ?>
            <tr class="frame">
                <td class="frame">
                    <?php
                    $subproductionlineID = $row['subproductionlineID'];
                    $query = "SELECT `users`.`name`
                FROM  `timestamp`
                INNER JOIN `users` ON 
                `users`.`employeeID` = `timestamp`.`employeeID`
                 WHERE 
                `timestamp`.`checksheetID` ='$checksheet' and `subproductionlineID` like '$subproductionlineID'";
                    $result1 = mysqli_query($connection, $query);
                    $row1 = mysqli_fetch_array($result1);

                    echo $row1['name'];
                    ?>
                </td>
                <td class="frame">
                    <?php
                    $query = "SELECT `routing`.`name` ,`routing`.`code`
FROM  `checksheet`
INNER JOIN `routing` ON `routing`.`id`=`checksheet`.`routing` WHERE  `checksheet`.`id` ='$checksheet'";
                  $result1=  mysqli_query($connection, $query);
                  $row1=  mysqli_fetch_array($result1);
                  echo $row1['code'];
                    ?>
                </td>
                <td class="frame">
                    <?php echo $row1['name']; ?>
                </td>
                <td class="frame" >
                    <?php 
                    $query="SELECT  `datetime` FROM `timestamp` WHERE  `checksheetID` ='$checksheet' and `subproductionlineID` ='$subproductionlineID'  AND `status` ='1' ORDER by  `datetime` ASC";
                    $result1=  mysqli_query($connection, $query);
                    $row1= mysqli_fetch_array($result1);
                    echo $row1['datetime'];
                    ?>
                </td>
                <td class="frame" >
                    <?php 
                    $query="SELECT  `datetime` FROM `timestamp` WHERE  `checksheetID` ='$checksheet' and `subproductionlineID` ='$subproductionlineID'  AND `status` ='0' ORDER by  `datetime` DESC";
                    $result1=  mysqli_query($connection, $query);
                    $row1= mysqli_fetch_array($result1);
                    echo $row1['datetime'];
                    ?>
                </td>
                
                
            </tr>
            <?php }
        ?>
    </tbody>
</table>