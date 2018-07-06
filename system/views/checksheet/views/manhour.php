<script src="../vender/typeahead.js" ></script>
<script >
    $(document).ready(function () {
        
        $('#employeeID').typeahead({
            source: function (query, result) {
                $.ajax({
                    url: "views/managementuser/query/employeeIDautocomplate.php",
                    data: 'employeeID=' + $("#employeeID").val(),
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
                        result($.map(data, function (item) {
                            return item;
                        }));
                    }
                });
            }
        });
        
        $("#search").click(function(){
             var url="&employeeID="+$("#employeeID").val()+"&from=" +$("#from").val()+"&to="+$("#to").val();
             if($("#employeeID").val()==""){
                  window.location.replace("?fragment=checksheet&component=manhour");
             }else{
                  window.location.replace("?fragment=checksheet&component=manhour" + url);
             }
           
        });



    });
</script>
<?php 
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
$time="00:00:00";
?>
<div class="row" style="background: buttonhighlight;" >
 
    <div  class="mb-3">
        <label for="employeeID">Employee ID</label>
        <input type="text" class="form-control " id="employeeID" name="employeeID" value=""  placeholder="Employee ID" required="">
    </div>
    <div  class="mb-3">
        <label for="from">From</label>
        <input type="date" class="form-control " id="from" name="from" value=""  placeholder="Name" required="">
    </div>
    <div  class="mb-3">
        <label for="to">To</label>
        <input type="date" class="form-control " id="to" name="to" value=""  placeholder="Name" required="">
    </div>
    <div class="col-md-3 mb-3">
        <label for="search">Search</label>
        <input type="button" class="form-control filter"  value="Search" id="search" placeholder="Search" required="">  
    </div>
</div>

<div class="row" >
    <table class="table" >
        <thead>
        <tr>
            <th>Name</th>
            <th>Lastname</th>
            <th>Employee ID</th>
            <th>Machine</th>
            <th>Start</th>
            <th>Stop</th>
            <th>Work Time</th>
        </tr>
        </thead>
        <tbody>
            <?php 
            $employeeID= isset($_GET['employeeID']) ? $_GET['employeeID']:"" ;
            $from= isset($_GET['from'] ) ? $_GET['from']:"" ;
            $to=isset($_GET['to']) ? $_GET['to']:"" ;
            if($employeeID==""){
                ?>
            <tr>
                <td colspan="7" style="text-align: center;"> Need Filter</td>
            </tr>
            <?php
            }else{
            $to=$to." 23:59:59";
            $query="SELECT * FROM `timestamp` WHERE `employeeID` like '$employeeID' and  `start_datetime` BETWEEN '%$from%' AND '$to'";
            $result=  mysqli_query($connection, $query);
           
            while ($row = mysqli_fetch_array($result)) {
                $subproductionlineID=$row['subproductionlineID'];
                $query="SELECT * FROM `users` WHERE `employeeID` like '$employeeID'";
                $r=  mysqli_query($connection, $query);
                $t=  mysqli_fetch_array($r);
            ?>
            <tr>
                <td><?php echo $t['name']; ?></td>
                <td><?php echo $t['lastname']; ?></td>
                <td><?php echo $employeeID; ?></td>
                <td><?php 
                $query="SELECT * FROM `subproductionline` WHERE `id` ='$subproductionlineID'";
                  $r=  mysqli_query($connection, $query);
                $t=  mysqli_fetch_array($r);
                echo $t['name'];
                ?></td>
                <td><?php echo  $row['start_datetime']; ?></td>
                <td><?php echo $row['end_datetime']; ?></td>
                <td>
                    <?php 
                    $start_datetime=$row['start_datetime'];
                    $end_datetime=$row['end_datetime'];
                    $query="SELECT TIMEDIFF('$end_datetime','$start_datetime') as time";
                    $q= mysqli_query($connection, $query);
                    $t=  mysqli_fetch_array($q);
                    $time=   sum_the_time($time, $t['time']);
                    
                    echo $t['time'];
                    ?>
                </td>
            </tr>
            <?php 
             }
          
            ?>
            <tr>
                <td colspan="6" style="text-align: right;">Total</td>
                <td><?php echo $time; ?></td>
            </tr>
            <?php  } ?>
        </tbody>
    </table>
</div>