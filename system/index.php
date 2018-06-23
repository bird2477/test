<?php
include '../config/database.php';
session_start();
if (!isset($_SESSION['id'])) {
    ?>
    <script >
        window.location.replace("../");
    </script>
    <?php
}
$fragment=  isset($_GET['fragment'])?$_GET['fragment']:"home";
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../css/bootstrap.css"  crossorigin="anonymous">
        <script src="../js/jquery.min.js" crossorigin="anonymous"></script>
        <script src="../js/bootstrap.js"  crossorigin="anonymous"></script>
        <meta charset="UTF-8">
     
        <title></title>
    </head>
    <body class="bg-light">
        <?php
        include './views/layout/nav.php';
        include './views/layout/content.php';
        include './views/layout/footer.php';
        ?>
    </body>
</html>

