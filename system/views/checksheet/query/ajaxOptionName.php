<?php
include '../../../../config/database.php';
$partcode=$_POST['partcode'];
$productioncode=$_POST['productioncode'];
$query="SELECT * FROM `routing` WHERE `productioncode` like '$productioncode' and `partcode` like '$partcode'";
 $result= mysqli_query($connection, $query);
 ?>
<option value="">Choose...</option>
<?php
 while ($row = mysqli_fetch_array($result)) {
     ?>
<option value="<?php echo $row['partname']; ?>" ><?php echo $row['partname']; ?></option>
<?php
    
}