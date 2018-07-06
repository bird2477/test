<?php
$query = "SELECT  `subproductionline`.`id`  ,`productionline`.`machine` as linename,`subproductionline`.`name`,`subproductionline`.`target`,`subproductionline`.`actual_total`,`subproductionline`.`free_total`,`subproductionline`.`reject_total`,`subproductionline`.`speed`
FROM `productionline` 
INNER JOIN `subproductionline` ON `productionline`.`id`= `subproductionline`.`productionline` WHERE  `subproductionline`.`status` ='1'  ORDER BY  `productionline`.`id` ASC";

$result = mysqli_query($connection, $query);
?> 

<script >
$(document).ready(function(){
    data();
    function data(){
        $.ajax({type: 'POST' ,url: "./views/checksheet/query/ajaxDashboard.php",cache: false,success: function (data, textStatus, jqXHR) {
                        $("#data").html(data);
                    }});
        call();
    }
    
    function call(){
        setTimeout(function(){
            data();
        },1000);
    }
});
</script>
<table class="table table-hover">
    <thead>
        <tr>
            <th>Lot No.</th>
            <th>Production line</th>
            <th>Machine name</th>
            <th>Target</th>
            <th>Actual Total</th>
            <th>Free Total</th>
            <th>Reject Total</th>
            <th>Speed</th>
        </tr>
    </thead>
    <tbody id="data">
        <?php
        while ($row = mysqli_fetch_array($result)) {
            ?>
            <tr>
                <td><?php 
                $id=$row['id'];
                $query ="SELECT * FROM `subchecksheet` WHERE `subproductionlineID` ='$id'";
                $r=  mysqli_query($connection, $query);
                $t=  mysqli_fetch_array($r);
                echo $t['lotno'];
                ?></td>
                <td><?php echo $row['linename']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td id="<?php echo 'target'.$row['id']; ?>"><?php echo $row['target']; ?></td>
                <td id="<?php echo 'actual_total'.$row['id']; ?>"><?php echo $row['actual_total']; ?></td>
                <td id="<?php echo 'free_total'.$row['id']; ?>"><?php echo $row['free_total']; ?></td>
                <td id="<?php echo 'reject_total'.$row['id']; ?>"><?php echo $row['reject_total']; ?></td>
                <td id="<?php echo 'speed'.$row['id']; ?>"><?php echo $row['speed']; ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>