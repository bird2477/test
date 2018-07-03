<?php
 include '../../../../config/database.php';
 $lotno=$_POST['lotno'];
 
 $query="SELECT * FROM `routing` WHERE `lotno` like '$lotno'";
 
 $result=  mysqli_query($connection, $query);
 $row=  mysqli_fetch_array($result);
 
 echo $row['target'] - $row['actual'];