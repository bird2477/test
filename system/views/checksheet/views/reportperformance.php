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
            <th class="frame">เวลาเริ่ม</th>
            <th class="frame">เวลาหยุด</th>
            <th class="frame">จำนวนงานดี</th>
            <th class="frame">Free shot</th>
            <th class="frame">จำนวนงานเสีย</th>

            <th class="frame">ชื่องาน</th>
            <th class="frame">จำนวนรวม</th>
            <th class="frame">ชือพนักงานผู้ผลิต</th>
        </tr>
    </thead>
    <tbody >
        <?php
        $date = $_GET['date'];
        $query = "SELECT * FROM `timestamp` WHERE `start_datetime` like '%$date%' ORDER BY `id` ";
        $result=  mysqli_query($connection, $query);
        while ($row = mysqli_fetch_array($result)) {
        ?>
        <tr>
            <td class="frame">
                <?php  
                $checksheetID=$row['checksheetID'];
                $subchecksheetID=$row['subchecksheetID'];
                $subproductionlineID=$row['subproductionlineID'];
                $query="SELECT * FROM `subproductionline` WHERE `id` ='$subproductionlineID'";
                $re=  mysqli_query($connection, $query);
                $ro=  mysqli_fetch_array($re);
                echo $ro['name'];
                ?>
            </td>
            <td class="frame"></td>
            <td class="frame"></td>
        </tr>
        <?php } ?>
    </tbody>
</table>