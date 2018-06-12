<script >
    $(document).ready(function () {

        $("#search").click(function () {
            var searchproductionline =$("#searchproductionline").val();
            var url = "&productionline="+searchproductionline;
            window.location.replace("?fragment=machine&component=machine" + url);
        });


    });

</script>



<div class="row" style="background: buttonhighlight;" >

    <div class="col-md-5 mb-3">
        <label for="searchproductionline">Production Line</label>
        <select class="custom-select d-block w-100" name="searchproductionline" id="searchproductionline" required="">
            <option value="">Choose...</option>
            <?php
            $query="SELECT * FROM `productionline` WHERE 1";
            
            $result=  mysqli_query($connection, $query);
            while ($row2 =  mysqli_fetch_array  ($result)) {
               
            ?>
            <option <?php if($_GET['productionline']==$row2['id']){ echo 'selected'; } ?> value="<?php echo $row2['id']; ?>"> <?php echo $row2['machine']; ?> </option> 
            <?php  
            }
            ?>
        </select>
       
    </div>


    <div class="col-md-3 mb-3">
        <label for="search">Search</label>
        <input type="button" class="form-control filter"  value="Search" id="search" placeholder="Search" required="">
        <div class="invalid-feedback">
            search required.
        </div>
    </div>


</div>


<div class="row">
    <table class="table table-condensed">
        <thead>
            <tr>
                <th>Production Line</th>
                <th>Tools</th>
            </tr>
        </thead>
        <tbody>
          <?php 
          $productionline=  isset($_GET['productionline']) ? $_GET['productionline'] :"";
          if($productionline==""){
              $query="SELECT * FROM `productionline` WHERE 1";
          }else{
               $query="SELECT * FROM `productionline` WHERE `id` = '$productionline'";
          }
          $result = mysqli_query($connection, $query);
          while ($row = mysqli_fetch_array($result)) {
          ?>
            <tr>
                <td><?php echo $row['machine']; ?></td>
                <td>
                    <a href="./views/machine/views/mapsubproductionline.php?productionline=<?php echo $row['id']; ?>"  class="btn btn-success " >
                        Map Sub Machine</a>
                </td>
            </tr>
            <?php      
          }
          ?>
        </tbody>
    </table>
</div>


