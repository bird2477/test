<!DOCTYPE html>
<?php
session_start();
if(isset($_SESSION['id'])){
    ?>
<script >
window.location.replace("./system");

</script>
<?php
}


?>
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
       
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
