<?php
$moldcode = isset($_GET['moldcode']) ? $_GET['moldcode'] : "";
$page = isset($_GET['page']) ? $_GET['page'] : 1;
if ($page == 1) {
    $page1 = "0,10";
} else {
    $page1 = ($page - 1) . "0," . ($page) . "0";
}
?>
<script src="../vender/typeahead.js" ></script>
<script >
    $(document).ready(function () {
        $(".remove").click(function () {
            var id = "id=" + $(this).attr("id");
            $.ajax({data: id, url: "views/mold/query/ajaxRemoveMold.php", type: 'POST', cache: false, success: function (data, textStatus, jqXHR) {

                    if (data == 1) {
                        window.location.reload();
                    }
                }});

        });

        $("#addmold").click(function () {
            var dataString = encodeURI($('#custoner').serialize());

            $.ajax({data: dataString, url: "views/mold/query/ajaxAddMold.php", type: 'POST', cache: false, success: function (data, textStatus, jqXHR) {
                    if (data == "1") {
                        alert('success');
                        window.location.reload();
                    }
                }});
        });
         
         $('#searchmoldcode').change(function(){
             var data="moldcode=" + $('#searchmoldcode').val();
             data=encodeURI(data);
             window.location.replace("?fragment=mold&component=mold&"+data);
         });
          $('#searchmoldcode').typeahead({
            source: function (query, result) {
                $.ajax({
                    url: "views/mold/query/moldcodeautocomplate.php",
                    data: 'moldcode=' + $("#searchmoldcode").val(),
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
                        result($.map(data, function (item) {
                            return item;
                        }));
                    }
                });
            }
        });




    });
</script>

<div class="row" >
    <table style="width: 100%;" >
        <tr>
            <td ></td>
            <td style="text-align: right;">
                <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#linemachine">
                    Add Mold
                </button>   
            </td>
        </tr>
    </table>
</div>



<div class="row" style="background: buttonhighlight;" >
    <div class="col-md-5 mb-3">
        <label for="searchmoldcode">Mold No</label>          
        <input class="form-control" type="text" value="<?php echo $moldcode; ?>" name="searchmoldcode" id="searchmoldcode">
    </div>
   
</div>
<div class="row">
    <table class="table table-condensed">
        <thead>
            <tr>
               
                <th>Mold No</th>
                <th>Production Code</th>
                <th>Part Code</th>
                <th>Part Name</th>
                
                <th>Customer</th>
                <th>Tools</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $cout=1;
            if ($moldcode != "") {

                $query = "SELECT * FROM `mold` WHERE `moldcode` like '%$moldcode%'";
                
                echo $query;
                $result = mysqli_query($connection, $query);
                while ($row1 = mysqli_fetch_array($result)) {
                    ?>
                    <tr>
                        
                        <td><?php echo urldecode($row1['moldcode']); ?></td>
                        <td><?php echo urldecode($row1['productioncode']); ?></td>
                        <td><?php echo urldecode($row1['partcode']); ?></td>
                        <td><?php echo urldecode($row1['partname']); ?></td>
                        <td><?php
            $id = $row1['customer'];
            $query = "SELECT * FROM `customer` WHERE `id` ='$id'";
            $result1 = mysqli_query($connection, $query);
            $row = mysqli_fetch_array($result1);
            echo $row['name'];
                    ?></td>
                        <td>

                            <button type="button" class="btn btn-danger remove" id="<?php echo $row1['id']; ?>">
                                Remove
                            </button>   
                        </td>
                    </tr>
                    <?php
                    $cout++;
                }
            } else {
                $query = "SELECT * FROM `mold` WHERE 1  limit $page1  ";
               
                $result = mysqli_query($connection, $query);
                if (mysqli_num_rows($result) > 0) {
                    while ($row2 = mysqli_fetch_array($result)) {
                        ?>
                        <tr>
                           
                            <td><?php echo urldecode(  $row2['moldcode']); ?></td>
                            <td><?php echo urldecode($row2['productioncode']); ?></td>
                            <td><?php echo urldecode($row2['partcode']); ?></td>
                            <td><?php echo urldecode($row2['partname']); ?></td>
                            <td><?php
                             $id = $row2['customer'];
                            $query = "SELECT * FROM `customer` WHERE `id` ='$id'";
                            
                            $result1 = mysqli_query($connection, $query);
                            $row = mysqli_fetch_array($result1);
                             echo $row['name'];
                        ?></td>
                            <td>

                                <button type="button" class="btn btn-danger remove" id="<?php echo $row2['id']; ?>">
                                    Remove
                                </button>   
                            </td>
                        </tr>
                        <?php
                        $cout++;
                    }
                } else {
                    ?>
                    <tr style="text-align: center;">
                        <td colspan="3"> No data</td>

                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
         <div class="container">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <?php 
                
                if($moldcode =="" ){
                    $query="SELECT * FROM `mold` WHERE 1";
                }else{
                     $query="SELECT * FROM `mold` WHERE `moldcode` like '%$moldcode%'";
                }
                
                
                
                $result=  mysqli_query($connection, $query);
                $num=  mysqli_num_rows($result)/10;
                $numrow=ceil($num);
                ?>
                <li class="page-item <?php if($page==1){ echo 'disabled';} ?>">
                    <a class="page-link " href="?fragment=mold&component=mold&moldcode=<?php echo $moldcode; ?>&page=<?php echo $page-1; ?>" tabindex="-1">Previous</a>
                </li>
                <?php for($i=1;$i<=$numrow;$i++){   ?>
                <li class="page-item <?php if($page==$i){    echo 'active';} ?>  "><a class="page-link" href="?fragment=mold&component=mold&moldcode=<?php echo $moldcode; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
               
                <?php } ?>
                <li class="page-item <?php if($page>= $numrow){ echo 'disabled';} ?>">
                    <a class="page-link " href="?fragment=mold&component=mold&moldcode=<?php echo $moldcode; ?>&page=<?php echo $page+1; ?>">Next</a>
                </li>
                
            </ul>
        </nav>
    </div>
</div>




<div id="linemachine" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                Add Mold
            </div>
            <div class="modal-body">
                <form id="custoner" >
                    <div class="row">
                        <label for="moldcode">Mold No</label>
                        <input type="text" class="form-control" id="moldcode" name="moldcode" placeholder="" required="">
                        <div class="invalid-feedback">
                            Please enter your shipping address.
                        </div>
                    </div>
                    <div class="row">
                        <label for="productioncode">Production Code</label>
                        <input type="text" class="form-control" id="productioncode" name="productioncode" placeholder="" required="">
                        <div class="invalid-feedback">
                            Please enter your shipping address.
                        </div>
                    </div>
                     <div class="row">
                        <label for="partcode">Part Code</label>
                        <input type="text" class="form-control" id="partcode" name="partcode" placeholder="" required="">
                        <div class="invalid-feedback">
                            Please enter your shipping address.
                        </div>
                    </div>
                    <div class="row">
                        <label for="partname">Part Name</label>
                        <input type="text" class="form-control" id="partname" name="partname" placeholder="" required="">
                        <div class="invalid-feedback">
                            Please enter your shipping address.
                        </div>
                    </div>
                    <div class="row">
                        <label for="customer">Customer</label>
                        <select class="custom-select d-block w-100" id="customer" name="customer" required="">
                            <option value="">Choose...</option>
                            <?php
                            $query = "SELECT * FROM `customer` WHERE 1";
                            $result = mysqli_query($connection, $query);
                            while ($row = mysqli_fetch_array($result)) {
                                ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                            <?php } ?>
                        </select>

                    </div>


            </div>
            </form>

            <div class="modal-footer">
                <button type="button" id="addmold" class="btn btn-default" data-dismiss="modal">Add</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

        </div>

    </div>
</div>