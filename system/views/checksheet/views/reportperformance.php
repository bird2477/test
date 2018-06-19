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
            <th class="frame">Machine Code</th>
            <th class="frame">Production Code</th>
            <th class="frame">Part Code</th>
            <th class="frame">Part Name</th>
            <th class="frame" >Target</th>
            <th class="frame" >Actual Total</th>
            <th class="frame" >Free Total</th>
            <th class="frame" >Reject Total</th>
            <th class="frame">เวลาเริ่ม</th>
            <th class="frame">เวลาหยุด</th>
            <th class="frame">Work Total</th>

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
                    $employeeID_use="";
                    $name="";
                    $subproductionlineID = $row['subproductionlineID'];
                    $query = "SELECT DISTINCT `employeeID` FROM `timestamp` WHERE `checksheetID` ='$checksheet' and `subproductionlineID` ='$subproductionlineID'";
                    $result1=  mysqli_query($connection, $query);
                    while ($row2 = mysqli_fetch_array($result1)) {
                        $employeeID=$row2['employeeID'];
                        $query="SELECT * FROM `users` WHERE `employeeID` like '$employeeID'";
                        $result2=  mysqli_query($connection, $query);
                        while ($row3 = mysqli_fetch_array($result2)) {
                            if($row3['privilege']>=1){
                                $employeeID_use=$row3['employeeID'];
                                $name=$row3['name'];
                            }
                        }
                    }
                    echo $name;
                    ?>
                </td>
                <td class="frame">
                    <?php
                    $query="SELECT * FROM `subproductionline` WHERE `id` ='$subproductionlineID'";
                    $result1=  mysqli_query($connection, $query);
                    $row1=  mysqli_fetch_array($result1);
                    echo $row1['name'];
                    $query = "SELECT `routing`.`productioncode` ,`routing`.`partcode` ,`routing`.`partname` FROM `checksheet` INNER JOIN `routing` ON `routing`.`id`=`checksheet`.`routing` WHERE `checksheet`.`id` ='$checksheet'";
                    $result1 = mysqli_query($connection, $query);
                    $row1 = mysqli_fetch_array($result1);
                    ?>
                </td>
                <td class="frame">
                    <?php
                    echo $row1['productioncode'];
                    ?>
                </td>
                <td class="frame">
                    <?php echo $row1['partcode']; ?>
                </td>
                <td class="frame">
                    <?php echo $row1['partname']; ?>
                </td>
                <td class="frame">
                    <?php echo $row['target']; ?>
                </td>
                <td class="frame">
                    <?php echo $row['actual_total']; ?>
                </td >
                <td class="frame">
                    <?php echo $row['free_total']; ?>
                </td>
                <td class="frame">
                    <?php echo $row['reject_total']; ?>
                </td>


                <td class="frame" >
                    <?php
                    $query = "SELECT  `datetime` FROM `timestamp` WHERE  `employeeID` like '$employeeID_use' and  `checksheetID` ='$checksheet' and `subproductionlineID` ='$subproductionlineID'  AND `status` ='1' ORDER by  `datetime` ASC";
                    $result1 = mysqli_query($connection, $query);
                    $row1 = mysqli_fetch_array($result1);
                    echo $row1['datetime'];
                    ?>
                </td>
                <td class="frame" >
                    <?php
                    $query = "SELECT  `datetime` FROM `timestamp` WHERE  `employeeID` like '$employeeID_use' and   `checksheetID` ='$checksheet' and `subproductionlineID` ='$subproductionlineID'  AND `status` ='0' ORDER by  `datetime` DESC";
                    $result1 = mysqli_query($connection, $query);
                    $row1 = mysqli_fetch_array($result1);
                    echo $row1['datetime'];
                    ?>
                </td>
                
                <td>
                    <?php
                    $query="SELECT * FROM `timestamp` WHERE `employeeID` like '$employeeID_use' ORDER by `datetime` ASC";
                    $result3=  mysqli_query($connection, $query);
                    $cou=0;
                    $time=0;
                    $fist="";
                    while ($row4 = mysqli_fetch_array($result3)) {
                        if(($cou % 2)==0){
                           $fist=$row4['timestamp']; 
                        }else{
                            $two=$row4['datetime'];
                            $query="SELECT DATEDIFF('$fist','$two') as time ";
                             $result4=  mysqli_query($connection, $query);
                             $rwo=  mysqli_fetch_array($result4);
                             $time = $time+ floatval( $rwo['time']);
                        }
                        $cou = $cou +1;
                    }
                    echo $time;
                    ?>
                </td>


            </tr>
        <?php }
        ?>
    </tbody>
</table>