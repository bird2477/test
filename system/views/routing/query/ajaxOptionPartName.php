<?php
include '../../../../config/database.php';
$productioncode=$_POST['productioncode'];
$query="SELECT * FROM `mold` WHERE `productioncode` like '$productioncode'";
 $result= mysqli_query($connection, $query);
 ?>
<option value="">Choose...</option>
<?php
 while ($row = mysqli_fetch_array($result)) {
     ?>
<option value="<?php echo $row['partcode']; ?>" ><?php echo $row['partcode']; ?></option>
<?php
    
}