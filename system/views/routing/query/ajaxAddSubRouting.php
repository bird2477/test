<?php
include '../../../../config/database.php';
$step=$_POST['step'];               
$detail=$_POST['detail'];               
$customer=$_POST['customer'];               
$partcode=$_POST['partcode'];               
$partname=$_POST['partname'];               
$productioncode=$_POST['product'];




$query="SELECT * FROM `mold` WHERE `customer` ='$customer' and `productioncode` like '$productioncode' and `partname` like '$partname' and `partcode` like '$partcode'";
$result=  mysqli_query($connection, $query);
$row=  mysqli_fetch_array($result);

$mold=$row['id'];               
$routing=$_POST['routing'];


$query="SELECT * FROM `subrouting` WHERE `routing` ='$routing' and `step` ='$step'";
$r=  mysqli_query($connection, $query);
$t=  mysqli_num_rows($r);
if($t<1){

$query="INSERT INTO `listsubproductionline`(`id`, `json`) VALUES (null,'')";
$result=mysqli_query($connection, $query);
$listsubproductionline_id  = mysqli_insert_id($connection);
$query="INSERT INTO `subrouting`(`id`, `routing`, `listsubproductionline_id`, `mold`, `step`, `detail`) VALUES "
                                . "(null,'$routing','$listsubproductionline_id','$mold','$step','$detail')";
if(mysqli_query($connection, $query)){
    echo '1';
    
}

}else{
    echo 'ขั้นตอนนี้มีอยู่แล้ว';
}

?>
