<?php
include '../../../../config/database.php';
$productionline=$_POST['productionline'];
$query="SELECT `code` FROM `routing` WHERE `productionline` ='$productionline'";
 $result= mysqli_query($connection, $query);
 ?>
<option value="">Choose...</option>
<?php
 while ($row = mysqli_fetch_array($result)) {
     ?>
<option value="<?php echo $row['code']; ?>" ><?php echo $row['code']; ?></option>
<?php
    
}