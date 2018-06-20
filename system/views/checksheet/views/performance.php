<script >
    $(document).ready(function () {
        $("#search").click(function () {

            var date = $("#date").val();
            var url = "date=" + date;
            window.location.replace("?fragment=checksheet&component=performance&" + url);
        });
    });
</script>
<div class="row" style="background: buttonhighlight;" >

    <div class="col-3" >
        <label for="date" class="col-form-label">Date</label>
        <input class="form-control" type="date" value="<?php
        $date=  isset($_GET['date']) ?  $_GET['date'] : date('Y-m-d');
        echo $date;
        ?>" name="date" id="date">
    </div>
    <div class="col-4" style="    margin-top: 7px;">
        <label for="search">Search</label>
        <input type="button" class="form-control filter"  value="Search" id="search" required="">
    </div>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ChecksheetID</th>
            <th>Production Code</th>
            <th>Part Code</th>
            <th>Part Name</th>
            <th>Tools</th>

        </tr>
    </thead>
    <tbody>
        <?php
        
        
           
          
            $query = "SELECT DISTINCT   `checksheet`.`id`,  `checksheet`.`routing`,`checksheet`.`date` FROM `checksheet` INNER JOIN `subchecksheet` ON `subchecksheet`.`checksheet` =`checksheet`.`id` WHERE `checksheet`. `date` like '$date'";

            $result = mysqli_query($connection, $query);
            if(mysqli_num_rows($result)>0){
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <?php
                    $routing = $row['routing'];
                    $query = "SELECT * FROM `routing` WHERE `id` like '$routing'";
                    $result1 = mysqli_query($connection, $query);
                    $row1 = mysqli_fetch_array($result1);
                    ?>
                    <td><?php echo $row['id'] ; ?></td>
                    <td>
                        <?php
                        echo $row1['productioncode'];
                        ?>
                    </td>
                    <td >
                        <?php
                        echo $row1['partcode'];
                        ?>
                    </td>
                    <td >
                        <?php
                        echo $row1['partname'];
                        ?>
                    </td>
                    <td>
                        <a class="btn btn-primary" target="_blank" href="./views/checksheet/views/reportperformance.php?checksheet=<?php echo $row['id']; ?>" >Report</a>    
                    </td>
                </tr>
                <?php
            }
            }else{
      
            ?>
            <tr>
                <td colspan="5" style="text-align: center;"> Need filter</td>
            </tr>
            <?php } ?>
    </tbody>
</table>

