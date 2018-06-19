<?php
include '../../../../config/database.php';
$productionline=$_POST['id'];
$query="SELECT * FROM `subproductionline` WHERE `productionline` ='$productionline'";
 $result= mysqli_query($connection, $query);
 ?>
<option value="">Choose...</option>
<?php
 while ($row = mysqli_fetch_array($result)) {
     ?>
<option value="<?php echo $row['id']; ?>" ><?php echo $row['name']; ?></option>
<?php
    
}