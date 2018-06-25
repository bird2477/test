<?php
include '../../../../config/database.php';
$date = $_GET['date'];

function sum_the_time($time1, $time2) {
    $times = array($time1, $time2);
    $seconds = 0;
    foreach ($times as $time) {
        list($hour, $minute, $second) = explode(':', $time);
        $seconds += $hour * 3600;
        $seconds += $minute * 60;
        $seconds += $second;
    }
    $hours = floor($seconds / 3600);
    $seconds -= $hours * 3600;
    $minutes = floor($seconds / 60);
    $seconds -= $minutes * 60;
    // return "{$hours}:{$minutes}:{$seconds}";
    return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds); // Thanks to Patrick
}
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
<table border="0" align="center"  style="width: 1024px; text-align: left;"  >
    <tr>
        <td><?php echo $date; ?></td>
    </tr>
</table>
<table border="0" align="center"  style="width: 1024px; text-align: center;" class="frame"  >

    <thead>
        <tr class="frame">
            <th class="frame">เครื่องจักร</th>
            <th class="frame">Counter Hr.</th>
            <th class="frame">ขั้นตอนแม่พิมพ์</th>
            <th class="frame">เวลาเริ่มติดตั้งแม่พิมพ์</th>
            <th class="frame">เวลาแล้วเสร็จติดตั้งแม่พิมพ์</th>
            <th class="frame">ชื่อพนักงาน SET</th>
            <th class="frame">เวลาเริ่มผลิต</th>
            <th class="frame">เวลาเริ่มสิ้นสุด</th>
            <th class="frame">จำนวนงานดี</th>
            <th class="frame">Free shot</th>
            <th class="frame">จำนวนงานเสีย</th>
            <th class="frame">ชือพนักงานผู้ผลิต</th>
            <th class="frame">ชื่องาน</th>
            <th class="frame">จำนวนรวม</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = "SELECT * FROM `checksheet` WHERE `date` like '$date'";

        $result = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_array($result)) {
            $checksheet = $row['id'];
            $query = "SELECT * FROM `subchecksheet` WHERE `checksheet` ='$checksheet'";
            $result1 = mysqli_query($connection, $query);
            while ($row1 = mysqli_fetch_array($result1)) {
                ?>
                <tr>
                    <td class="frame">
                        <?php
                        $subproductionline = $row1['subproductionlineID'];
                        $query = "SELECT * FROM `subproductionline` WHERE `id` ='$subproductionline'";
                        $colum = mysqli_query($connection, $query);
                        $row2 = mysqli_fetch_array($colum);
                        echo $row2['name'];
                        ?>
                    </td>
                    <td class="frame">
                        <?php
                        $query = "SELECT `datetime` FROM `timestamp` WHERE  `checksheetID` ='$checksheet' and `status` ='1' and `subproductionlineID` ='$subproductionline'";
                        $c = mysqli_query($connection, $query);
                        $r1 = array();
                        while ($row4 = mysqli_fetch_array($c)) {
                            $r1[] = $row4['datetime'];
                        }
                        $query = "SELECT `datetime` FROM `timestamp` WHERE `checksheetID`='$checksheet'  and `status` ='0'  and `subproductionlineID` ='$subproductionline'";

                        $c = mysqli_query($connection, $query);
                        $r2 = array();
                        while ($row4 = mysqli_fetch_array($c)) {
                            $r2[] = $row4['datetime'];
                        }
                        $cout = 0;
                        $time = array();
                        foreach ($r1 as $r) {
                            $r3 = $r2[$cout];
                            $query = "SELECT TIMEDIFF('$r3','$r') as diff";

                            $c1 = mysqli_query($connection, $query);
                            $r4 = mysqli_fetch_array($c1);
                            $time[] = $r4['diff'];
                            $cout++;
                        }
                    
                        if ( (sizeof($time) > 0)) {
                         
                            $sumold="00:00:00";
                            for ($i = 0; $i < sizeof($time); $i++) {
                                $sumold=sum_the_time($sumold, $time[$i]);
                            }
                            echo $sumold;
                        }
                        ?>
                    </td>
                    <td class="frame">
                        <?php
                        $routing = $row['routing'];
                        $query = "SELECT  `mold` FROM `subrouting` WHERE `routing` ='$routing' and `subproductiononline` ='$subproductionline'";
                        $colum = mysqli_query($connection, $query);
                        $row2 = mysqli_fetch_array($colum);
                        $mold = $row2['mold'];
                        $query = "SELECT * FROM `mold` WHERE `id` ='$mold'";
                        $colum = mysqli_query($connection, $query);
                        $row2 = mysqli_fetch_array($colum);
                        echo urldecode($row2['detail']);
                        ?>
                    </td>
                    <td class="frame">
                        <?php
                        $query = "SELECT * FROM `timestamp` WHERE `checksheetID` ='$checksheet' and `subproductionlineID` ='$subproductionline' and `status` ='1'";
                        $colum = mysqli_query($connection, $query);
                        $employeeIDUse = "";
                        while ($row2 = mysqli_fetch_array($colum)) {
                            $employeeID = $row2['employeeID'];
                            $query = "SELECT * FROM `users` WHERE `employeeID` like '$employeeID'";
                            $colum1 = mysqli_query($connection, $query);
                            $row3 = mysqli_fetch_array($colum1);
                            if ($row3['privilege'] == "0") {
                                $employeeIDUse = $row3['employeeID'];
                            }
                        }
                        $query = "SELECT * FROM `timestamp` WHERE `employeeID` like '$employeeIDUse' and `checksheetID` ='$checksheet' and `subproductionlineID` ='$subproductionline'  and `status` ='1' ";

                        $colum = mysqli_query($connection, $query);
                        $row2 = mysqli_fetch_array($colum);
                        if ($row2['datetime'] != "") {
                            $date = date_create($row2['datetime']);
                            echo date_format($date, "H:i:s");
                        }
                        ?>
                    </td>
                    <td class="frame">
                        <?php
                        $query = "SELECT * FROM `timestamp` WHERE `checksheetID` ='$checksheet' and `subproductionlineID` ='$subproductionline' and `status` ='0' order by `datetime` DESC";
                        $colum = mysqli_query($connection, $query);
                        $employeeIDUse = "";
                        $name = "";
                        while ($row2 = mysqli_fetch_array($colum)) {
                            $employeeID = $row2['employeeID'];
                            $query = "SELECT * FROM `users` WHERE `employeeID` like '$employeeID'";
                            $colum1 = mysqli_query($connection, $query);
                            $row3 = mysqli_fetch_array($colum1);
                            if ($row3['privilege'] == "0") {
                                $employeeIDUse = $row3['employeeID'];
                                $name = $row3['name'];
                            }
                        }
                        $query = "SELECT * FROM `timestamp` WHERE `employeeID` like '$employeeIDUse' and `checksheetID` ='$checksheet' and `subproductionlineID` ='$subproductionline' and `status` ='0' order by `datetime` DESC ";

                        $colum = mysqli_query($connection, $query);
                        $row2 = mysqli_fetch_array($colum);
                        if ($row2['datetime'] != "") {
                            $date = date_create($row2['datetime']);
                            echo date_format($date, "H:i:s");
                        }
                        ?>
                    </td>
                    <td class="frame">
                        <?php echo $name; ?>
                    </td>
                    <td class="frame" >
                        <?php
                        $query = "SELECT * FROM `timestamp` WHERE `checksheetID` ='$checksheet' and `subproductionlineID` ='$subproductionline' and `status` ='1'";
                        $colum = mysqli_query($connection, $query);
                        $employeeIDUse = "";
                        while ($row2 = mysqli_fetch_array($colum)) {
                            $employeeID = $row2['employeeID'];
                            $query = "SELECT * FROM `users` WHERE `employeeID` like '$employeeID'";
                            $colum1 = mysqli_query($connection, $query);
                            $row3 = mysqli_fetch_array($colum1);
                            if ($row3['privilege'] == "1") {
                                $employeeIDUse = $row3['employeeID'];
                            }
                        }
                        $query = "SELECT * FROM `timestamp` WHERE `employeeID` like '$employeeIDUse' and `checksheetID` ='$checksheet' and `subproductionlineID` ='$subproductionline'  and `status` ='1' ";

                        $colum = mysqli_query($connection, $query);
                        $row2 = mysqli_fetch_array($colum);
                        if ($row2['datetime'] != "") {
                            $date = date_create($row2['datetime']);
                            echo date_format($date, "H:i:s");
                        }
                        ?>
                    </td>
                    <td class="frame" >
                        <?php
                        $query = "SELECT * FROM `timestamp` WHERE `checksheetID` ='$checksheet' and `subproductionlineID` ='$subproductionline' and `status` ='0' order by `datetime` DESC";
                        $colum = mysqli_query($connection, $query);
                        $employeeIDUse = "";
                        $name = "";
                        while ($row2 = mysqli_fetch_array($colum)) {
                            $employeeID = $row2['employeeID'];
                            $query = "SELECT * FROM `users` WHERE `employeeID` like '$employeeID'";
                            $colum1 = mysqli_query($connection, $query);
                            $row3 = mysqli_fetch_array($colum1);
                            if ($row3['privilege'] == "1") {
                                $employeeIDUse = $row3['employeeID'];
                                $name = $row3['name'];
                            }
                        }
                        $query = "SELECT * FROM `timestamp` WHERE `employeeID` like '$employeeIDUse' and `checksheetID` ='$checksheet' and `subproductionlineID` ='$subproductionline' and `status` ='0' order by `datetime` DESC ";

                        $colum = mysqli_query($connection, $query);
                        $row2 = mysqli_fetch_array($colum);
                        if ($row2['datetime'] != "") {
                            $date = date_create($row2['datetime']);
                            echo date_format($date, "H:i:s");
                        }
                        ?>
                    </td>
                    <td class="frame">
                        <?php
                        echo floatval($row1['actual_total']) - floatval($row1['free_total']) - floatval($row1['reject_total']);
                        ?>
                    </td>
                    <td class="frame" >
                        <?php
                        echo $row1['free_total'];
                        ?>
                    </td>
                    <td class="frame" >
                        <?php
                        echo $row1['reject_total'];
                        ?>
                    </td>
                    <td class="frame">
                        <?php echo $name; ?>
                    </td>
                    <td class="frame">
                        <?php
                        $query = "SELECT * FROM `routing` WHERE `id` ='$routing'";
                        $c = mysqli_query($connection, $query);
                        $r = mysqli_fetch_array($c);
                        echo $r['partcode'];
                        ?>
                    </td>
                    <td class="frame">
                        <?php echo $row1['actual_total']; ?>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>