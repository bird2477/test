<?php
include '../../../../config/database.php';
$productioncode=$_POST['partname'];
$query="SELECT * FROM `mold` WHERE `partname` like '$productioncode'";
 $result= mysqli_query($connection, $query);
 $row=  mysqli_fetch_array($result);
 $customer=$row['customer'];
 $query="SELECT * FROM `customer` WHERE `id` ='$customer'";
 $result= mysqli_query($connection, $query);

 ?>
<option value="">Choose...</option>
<?php
 while ($row = mysqli_fetch_array($result)) {
     ?>
<option value="<?php echo $row['id']; ?>" ><?php echo $row['name']; ?></option>
<?php
    
}