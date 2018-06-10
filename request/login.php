<?php
session_start();
$username=$_POST['username'];
$password=$_POST['password'];
include '../config/database.php';
$query="SELECT * FROM `users` WHERE `username` like '$username' and password like '$password'";


$result=   mysqli_query($connection, $query);
$check=mysqli_num_rows($result);

if($check ) {
    
    $fate=  mysqli_fetch_assoc($result);
    
    
    foreach ($fate as $key => $value){
        
        $_SESSION[$key]=$value;
       
    }
   
    ?>
<script >
window.location.replace("../system");

</script>
    <?php
}else{
?>
<script >
window.location.replace("../");

</script>
<?php
}
