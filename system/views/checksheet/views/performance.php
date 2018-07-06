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
            
            <th>Date</th>
           
           
            <th>Tools</th>

        </tr>
    </thead>
    <tbody>
        <?php
            $query = "SELECT SUM(`traget`) as target ,`date` FROM `checksheet` WHERE `date` like '$date'";
          
            $result = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_array($result)) {
                if(is_null ($row['target'])==FALSE){
                ?>
                <tr>
                   <td><?php echo $row['date'] ; ?></td>
                   
                   
                    <td>
                        <a class="btn btn-primary" target="_blank" href="./views/checksheet/views/reportperformance.php?date=<?php echo $row['date']; ?>" >Report</a>    
                    </td>
                </tr>
                <?php  
            }
            else{
      
            ?>
            <tr>
                <td colspan="5" style="text-align: center;"> Need filter</td>
            </tr>
            <?php 
            
            }
            
            
            } ?>
    </tbody>
</table>

