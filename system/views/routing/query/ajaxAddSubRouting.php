<?php
include '../../../../config/database.php';
$step=$_POST['step'];               
$detail=$_POST['detail'];               
$customer=$_POST['customer'];               
$partcode=$_POST['partcode'];               
$partname=$_POST['partname'];               
$productioncode=$_POST['productioncode']; 
$query="SELECT * FROM `mold` WHERE `customer` ='$customer' and `productioncode` like '$productioncode' and `partname` like '$partname' and `partcode` like '$partcode'";
$result=  mysqli_query($connection, $query);
$row=  mysqli_fetch_array($result);

$mold=$row['id'];               
$routing=$_POST['routing'];
$query="INSERT INTO `listsubproductionline`(`id`, `json`) VALUES (null,'')";
$result=mysqli_query($connection, $query);
$listsubproductionline_id  = mysqli_insert_id($connection);
$query="INSERT INTO `subrouting`(`id`, `routing`, `listsubproductionline_id`, `mold`, `step`, `detail`) VALUES "
                                . "(null,'$routing','$listsubproductionline_id','$mold','$step','$detail')";
if(mysqli_query($connection, $query)){
    echo '1';
    
}?>
