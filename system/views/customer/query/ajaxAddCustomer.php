<?php
include '../../../../config/database.php';
$taxno=$_POST['taxno'];
$companynameTH=$_POST['companynameTH'];
$companynameEN=$_POST['companynameEN'];

$query="INSERT INTO `customer`(`id`, `taxno`, `companynameTH`, `companynameEN`) VALUES "
                                . "(null,'$taxno','$companynameTH','$companynameEN')";
if(mysqli_query($connection, $query)){
    echo '1';
}
