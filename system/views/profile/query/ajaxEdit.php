<?php
session_start();
include '../../../../config/database.php';


$id = $_POST['id'];
$name=$_POST['name'];
$lastname=$_POST['lastname'];
$username=$_POST['username'];
$password=$_POST['password'];



$query="UPDATE `users` SET "
        . "`name`='$name',"
        . "`lastname`='$lastname',"
        . "`username`='$username',"  
       
        . "`password`='$password' WHERE `id` ='$id'";

if(mysqli_query($connection, $query)){
    echo '1';
    $_SESSION['name'] =$_POST['name'];
    $_SESSION['lastname'] =$_POST['lastname'];
    $_SESSION['username'] =$_POST['username'];
    $_SESSION['password'] =$_POST['password'];
    
    ?>

<?php
}

if(isset($_POST['profile'])){
    ?>
<script >
    window.location.replace("../../../index.php?fragment=profile&component=profile");
</script>
<?php
}
?>
