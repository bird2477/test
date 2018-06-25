<?php
include '../../../../config/database.php';
$productionline=$_POST['id'];
$query="SELECT * FROM `mold` WHERE `customer` ='$productionline'";
 $result= mysqli_query($connection, $query);
 ?>
<option value="">Choose...</option>
<?php
 while ($row = mysqli_fetch_array($result)) {
     ?>
<option value="<?php echo $row['id']; ?>" ><?php echo "Mold No = ".$row['moldcode'].": ".urldecode($row['detail']); ?></option>
<?php
    
}