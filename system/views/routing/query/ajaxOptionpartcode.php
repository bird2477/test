<?php
include '../../../../config/database.php';
$productioncode=$_POST['partcode'];
$query="SELECT * FROM `mold` WHERE `partcode` like '$productioncode'";
 $result= mysqli_query($connection, $query);
 ?>
<option value="">Choose...</option>
<?php
 while ($row = mysqli_fetch_array($result)) {
     ?>
<option value="<?php echo $row['partname']; ?>" ><?php echo $row['partname']; ?></option>
<?php
    
}