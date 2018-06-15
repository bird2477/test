<?php
include '../../../../config/database.php';
$query = "SELECT  `subproductionline`.`id`  ,`productionline`.`machine` as linename,`subproductionline`.`name`,`subproductionline`.`target`,`subproductionline`.`actual_total`,`subproductionline`.`free_total`,`subproductionline`.`reject_total`,`subproductionline`.`speed`
FROM `productionline` 
INNER JOIN `subproductionline` ON `productionline`.`id`= `subproductionline`.`productionline` WHERE  `subproductionline`.`status` ='1'  ORDER BY  `productionline`.`id` ASC";

$result = mysqli_query($connection, $query);
?> 
<?php
        while ($row = mysqli_fetch_array($result)) {
            ?>
            <tr>
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