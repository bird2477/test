<?php
include '../../../../config/database.php';
$productionline=$_POST['productionline'];
$code=$_POST['code'];
$query="SELECT `name` FROM `routing` WHERE `productionline` ='$productionline'  and  `code` like '$code'";
 $result= mysqli_query($connection, $query);
 ?>
<option value="">Choose...</option>
<?php
 while ($row = mysqli_fetch_array($result)) {
     ?>
<option value="<?php echo $row['name']; ?>" ><?php echo $row['name']; ?></option>
<?php
    
}