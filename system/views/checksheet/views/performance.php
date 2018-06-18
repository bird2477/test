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
        if (isset($_GET['date'])) {
            echo $_GET['date'];
        }
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
            <th>Production Line</th>
            <th>Tools</th>

        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($_GET['date'])) {
            $date = $_GET['date'];
            $query = "SELECT DISTINCT   `checksheet`.`id`,  `checksheet`.`routing`,`checksheet`.`date` FROM `checksheet` INNER JOIN `subchecksheet` ON `subchecksheet`.`checksheet` =`checksheet`.`id` WHERE `checksheet`. `date` like '$date'";
            echo $query;
            $result = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <td><?php
                        $routing = $row['routing'];
                        $query = "SELECT * FROM `routing` WHERE `id` like '$routing'";
                        $result1 = mysqli_query($connection, $query);
                        $row1 = mysqli_fetch_array($result1);
                        $productionline = $row1['productionline'];
                        $query = "SELECT * FROM `productionline` WHERE `id` ='$productionline'";
                        $result1 = mysqli_query($connection, $query);
                        $row1 = mysqli_fetch_array($result1);
                        echo $row1['machine'];
                        ?>
                    </td>
                    <td>
                        <a class="btn btn-primary" target="_blank" href="./views/checksheet/views/reportperformance.php?checksheet=<?php echo $row['id']; ?>" >Report</a>    
                    </td>
                </tr>
                <?php
            }
        } else {
            ?>
                <tr>
                    <td colspan="2" style="text-align: center;"> Need filter</td>
                </tr>
        <?php } ?>
    </tbody>
</table>

