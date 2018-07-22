<?php
include '../../../../config/database.php';
$query = "SELECT `subproductionline`. `checksheetID`  , `subproductionline`.`id`  ,`productionline`.`machine` as linename,`subproductionline`.`name`,`subproductionline`.`target`,`subproductionline`.`actual_total`,`subproductionline`.`free_total`,`subproductionline`.`reject_total`,`subproductionline`.`speed`
FROM `productionline` 
INNER JOIN `subproductionline` ON `productionline`.`id`= `subproductionline`.`productionline` WHERE  `subproductionline`.`status` ='1'  ORDER BY  `productionline`.`id` ASC";
$lotno =$_POST['lotno'];

$result = mysqli_query($connection, $query);
?> 
<?php
        while ($row = mysqli_fetch_array($result)) {
                
                $checksheetID=$row['checksheetID'];
                $subproductionline=$row['id'];
                $id=$row['id'];
                $query ="SELECT * FROM `routing` WHERE `id` =(SELECT `routing` FROM `checksheet` WHERE `id` ='$checksheetID')";
               
                $r=  mysqli_query($connection, $query);
                $t=  mysqli_fetch_array($r);
                if($lotno !=""){
                    if($lotno==$t['lotno']){
                        
                    }else{
                        continue;
                    }
                }else{
                    
                }
                
                
                $query="SELECT * FROM `timestamp` WHERE  `subproductionlineID` ='$subproductionline' and `checksheetID`='$checksheetID'";
                $r=  mysqli_query($connection, $query);
                $actual_total=0;
                $free_total=0;
                $reject_total=0;
                while ($row1 = mysqli_fetch_array($r)) {
                    $actual_total =$actual_total+$row1['actual'];
                    $free_total =$free_total+$row1['free'];
                    $reject_total =$reject_total+$row1['reject'];
                }
            
            ?>
            <tr>
                <td><?php 
                echo $t['lotno'];
                ?></td>
                <td><?php echo $row['linename']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td id="<?php echo 'target'.$row['id']; ?>"><?php echo $row['target']; ?></td>
                <td id="<?php echo 'actual_total'.$row['id']; ?>"><?php echo $actual_total+$row['actual_total']; ?></td>
                <td id="<?php echo 'free_total'.$row['id']; ?>"><?php echo $free_total+$row['free_total']; ?></td>
                <td id="<?php echo 'reject_total'.$row['id']; ?>"><?php echo $reject_total+$row['reject_total']; ?></td>
                <td id="<?php echo 'speed'.$row['id']; ?>"><?php echo $actual_total+ $row['actual_total']- $row['free_total']- $row['reject_total']-$reject_total-$free_total; ?></td>
            </tr>
            <?php
        }
        ?>