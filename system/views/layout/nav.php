<nav class="navbar navbar-expand-md navbar-dark bg-dark " >
    <a class="navbar-brand" href="?fragment=home">Real Time System</a>
  

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">

            <?php
            $privilege = $_SESSION['privilege'];
            $query = "SELECT * FROM `projectmodel` WHERE `privilege` <= '$privilege'  ORDER BY  id  ASC";
            $result = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_array($result)) {
                if($row['fragment']=="profile")
                    continue;
                
                ?>
                <li class="nav-item <?php if ($fragment == $row['fragment']) {
                echo 'active';
            } ?>">
                    <a class="nav-link" href="?fragment=<?php echo $row['fragment']; ?>"><?php echo $row['title']; ?> </a>
                </li>
                <?php
            }
            ?>


        </ul>
        <form method="" action="../request/logout.php" class="form-inline my-2 my-lg-0">
             <a class="btn btn-info my-2 my-sm-0" href="?fragment=profile&component=profile">Profile </a>
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Log out</button>
        </form>
    </div>
</nav>
 <?php  
 
        $query="SELECT * FROM `component` WHERE `projectfragment` LIKE '$fragment' and `privilege` <= '$privilege' ";
        $result=  mysqli_query($connection, $query);
        $rows=  mysqli_num_rows($result);
        if($rows>0){
        ?>
<div class="nav-scroller bg-white box-shadow">
      <nav class="nav nav-underline">
       
        <?php   
        $component=  isset($_GET['component']) ?$_GET['component'] :"home";
        while ($row1 = mysqli_fetch_array($result)) {
         ?>
          <a class="nav-link   <?php if ($component == $row1['fragment']) {
                echo 'active';
            } ?>" href="?fragment=<?php echo $fragment; ?>&component=<?php echo  $row1['fragment'] ?>"><?php echo $row1['title']; ?></a>
        
<?php
    }?>
      </nav>
</div>
        <?php } ?>