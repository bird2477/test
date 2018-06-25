<!DOCTYPE html>
<?php
session_start();
if (isset($_SESSION['id'])) {
    ?>
    <script >
        window.location.replace("./system");

    </script>
    <?php
}
?>
<html>
    <head>
        <link rel="stylesheet" href="css/bootstrap.css"  crossorigin="anonymous">
        <script src="js/jquery.min.js" crossorigin="anonymous"></script>
        <script src="../js/poper.js"  crossorigin="anonymous"></script>
        <script src="js/bootstrap.js"  crossorigin="anonymous"></script>

        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/sigin.css" >
        <title></title>
    </head>
    <body class="text-center">


        <form class="form-signin" action="request/login.php" method="POST">

            <h1 class="h3 mb-3 font-weight-normal">Please Log in</h1>
            <label for="username" class="sr-only">Username</label>
            <input type="text" id="username" class="form-control" name="username" placeholder="Username" required="" autofocus="">
            <label for="password" class="sr-only">Password</label>
            <input type="password" id="password" class="form-control" name="password" placeholder="Password" required="">

            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>

        </form>

    </body>
</html>
