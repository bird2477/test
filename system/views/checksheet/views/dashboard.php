<?php
$query = "SELECT  `subproductionline`.`id`  ,`productionline`.`machine` as linename,`subproductionline`.`name`,`subproductionline`.`target`,`subproductionline`.`actual_total`,`subproductionline`.`free_total`,`subproductionline`.`reject_total`,`subproductionline`.`speed`
FROM `productionline` 
INNER JOIN `subproductionline` ON `productionline`.`id`= `subproductionline`.`productionline` WHERE  `subproductionline`.`status` ='1'  ORDER BY  `productionline`.`id` ASC";

$result = mysqli_query($connection, $query);
$lotno = isset($_GET['lotno'])? $_GET['lotno'] :"";
?> 
<script src="../vender/typeahead.js" ></script>
<script >
$(document).ready(function(){
    
    $('#lotno').typeahead({
            source: function (query, result) {
                var datas='lotno=' + $(".lotno").val();
                
               
                $.ajax({
                    url: "views/checksheet/query/codeautocomplate.php",
                    data: datas,
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
    
    
    $(".filter").click(function(){
        var url ="?fragment=checksheet&component=dashboard&lotno="+$("#lotno").val();
        window.location.replace(url);
    });
    
    data();
    function data(){
        var lotno="lotno="+$("#lotno").val();
        $.ajax({data: lotno,type: 'POST' ,url: "./views/checksheet/query/ajaxDashboard.php",cache: false,success: function (data, textStatus, jqXHR) {
            console.log(data);          
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

<div class="row" style="background: buttonhighlight;" >

    <div class="col-3" >
        <label for="lotno" class="col-form-label"><a href="?fragment=checksheet&component=dashboard" >Product Lot No.</a></label>
        <input class="form-control lotno" autocomplete="off"   type="text" value="<?php echo $lotno; ?>" name="lotno" id="lotno">
    </div>
    
</div>


<table class="table table-hover">
    <thead>
        <tr>
            <th>Product Lot No.</th>
            <th>Production line</th>
            <th>Machine name</th>
            <th>Target</th>
            <th>Actual Total</th>
            <th>Free Total</th>
            <th>Reject Total</th>
            <th>Actual Goods</th>
        </tr>
    </thead>
    <tbody id="data">
        <?php
        while ($row = mysqli_fetch_array($result)) {
            ?>
            <tr>
                <td><?php 
                $id=$row['id'];
                $query ="SELECT * FROM `routing` WHERE `id` =(SELECT `routing` FROM `checksheet` WHERE `id` =(SELECT `checksheet` FROM `subchecksheet` WHERE `subproductionlineID` ='$id'))";
                $r=  mysqli_query($connection, $query);
                $t=  mysqli_fetch_array($r);
               
                echo $t['lotno'];
                ?></td>
                <td><?php echo $row['']; ?></td>
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