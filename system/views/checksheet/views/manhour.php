<?php
$employeeID = isset($_GET['employeeID']) ? $_GET['employeeID'] : "";
$from = isset($_GET['from']) ? $_GET['from'] : "";
$to = isset($_GET['to']) ? $_GET['to'] : "";
$page = isset($_GET['page']) ? $_GET['page'] : 1;


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
<script src="../vender/typeahead.js" ></script>
<script >
    $(document).ready(function () {
        $('.name').typeahead({
            source: function (query, result) {
                $.ajax({
                    url: "views/checksheet/query/usernameautocomplate.php",
                    data: 'name=' + $("#name1").val(),
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

        $("#search").click(function () {
            var url = $("#form").serialize();
            window.location.replace("?fragment=checksheet&component=manhour&" + url);

        });

    });


</script>
<form id="form" >
    <div class="row" style="background: buttonhighlight;" >

        <div class=" col-3">
            <label for="employeeID">Employee ID</label>
            <input type="text" class="form-control name " id="employeeID" name="employeeID" value="<?php echo $employeeID; ?>"  placeholder="Employee ID" required="">
        </div>
        <div class=" col-3">
            <label for="from">From</label>
            <input class="form-control" type="date" value="<?php
            if (isset($_GET['from'])) {
                echo $_GET['from'];
            }
            ?>" name="from" id="from">
        </div>
        <div  class=" col-3">
            <label for="to">To</label>
            <input class="form-control" type="date" value="<?php
            if (isset($_GET['to'])) {
                echo $_GET['to'];
            }
            ?>" name="to" id="to" >
        </div>

        <div class="col-3">
            <label for="search">Search</label>
            <input type="button" class="form-control filter"  value="Search" id="search" placeholder="Search" required="">
            <div class="invalid-feedback">
                search required.
            </div>
        </div>


    </div>
</form>
<table class="table table-condensed">
    <thead>
        <tr>
            <th>Employee ID</th>
            <th>name</th>
            <th>Total Time</th>
        </tr>
    </thead>
    <tbody>

        <?php
        $query = "SELECT  `datetime` FROM `timestamp` WHERE `employeeID` LIKE '$employeeID' and `datetime` BETWEEN '$from' and '$to' and  `status` ='1' ";
        $result = mysqli_query($connection, $query);
        $time1=array();
        while ($row = mysqli_fetch_array($result)) {
            $time1[] =$row['datetime'];
        }
        
        $query = "SELECT  `datetime` FROM `timestamp` WHERE `employeeID` LIKE '$employeeID' and `datetime` BETWEEN '$from' and '$to' and  `status` ='0' ";
        $result = mysqli_query($connection, $query);
        $time2=array();
        while ($row = mysqli_fetch_array($result)) {
            $time2[] =$row['datetime'];
        }
             $cout = 0;
                        $time = array();
                        foreach ($time1 as $r) {
                            $r3 = $time2[$cout];
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
                            
                        }
        
        ?>
        <?php 
        if($employeeID==""){
            $query="SELECT * FROM `users` WHERE 1";
        }else{
             $query="SELECT * FROM `users` WHERE `employeeID`  like '$employeeID'";
        }
        $result=  mysqli_query($connection, $query);
        while ($row = mysqli_fetch_array($result)) {
        
        ?>
        <tr>
            <td><?php echo $row['employeeID']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php  if($employeeID==""){            echo "filter it";  }else{    echo  $sumold; } ?></td>
        </tr>
        <?php    
        }
        ?>
    </tbody>
</table>
