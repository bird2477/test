
<main role="main" class="container">
    <?php
    $query="SELECT * FROM `projectmodel` WHERE `fragment` like '$fragment'";
    $result=  mysqli_query($connection, $query);
    $row=  mysqli_fetch_array($result);
    include  $row['path'];
    ?>
</main>
