<?php
include '../../../../config/database.php';
$productionline=$_POST['productionline'];
$name=$_POST['name'];
$type=$_POST['type'];
$capability=$_POST['capability'];
$model=$_POST['model'];
$brandname=$_POST['brandname'];
$areasize=$_POST['areasize'];
$ramsize=$_POST['ramsize'];
$blostersize=$_POST['blostersize'];
$slideadj=$_POST['slideadj'];
$strokelength=$_POST['strokelength'];
$SPM=$_POST['SPM'];
$volt=$_POST['volt'];
$amp=$_POST['amp'];
$hp=$_POST['hp'];

$query ="INSERT INTO `subproductionline`(`id`, `productionline`, `name`, `type`, `capability`, `model`, `brandname`, `areasize`, `ramsize`, `blostersize`, `slideadj`, `strokelength`, `SPM`, `volt`, `amp`, `hp`) VALUES "
                                        . "(null,'$productionline','$name','$type','$capability','$model','$brandname','$areasize','$ramsize','$blostersize','$slideadj','$strokelength','$SPM','$volt','$amp','$hp')";

if(mysqli_query($connection, $query)){
    echo '1';
}