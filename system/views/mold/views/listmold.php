<?php
$productioncode = isset($_GET['productioncode']) ? $_GET['productioncode'] : "";
$page = isset($_GET['page']) ? $_GET['page'] : 1;
if ($page == 1) {
    $page1 = "0,10";
    $cout1 = 0;
} else {
    $page1 = ($page - 1) . "0," . ($page) . "0";
    $cout1 = ($page - 1) * 10;
}
 $lastname1 = ($page) * 10;

                $start1 = 0;
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
        $("#productioncode").change(function(){
             var id = "name=" +  $("#productioncode").val();
             $.ajax({data: id, url: "views/mold/query/check.php", type: 'POST', cache: false, success: function (data, textStatus, jqXHR) {

                    if (data != 0) {
                        $("#productioncode").val("");
                        alert("มีข้อมูลอยู่แล้ว");
                    }
                }});
        });
        $("#addmold").click(function () {
            var dataString = encodeURI($('#custoner').serialize());
            var productioncode = $("#productioncode").val();
            var partcode = $("#partcode").val();
            var partname = $("#partname").val();
            var customer = $("#customer").val();
            
            if((productioncode=="")||(partcode=="")||(partname=="")||(customer=="")){
                alert("กรุณาใส่ค่าให้ครับ");
            }else{
             
            
            $.ajax({data: dataString, url: "views/mold/query/ajaxAddMold.php", type: 'POST', cache: false, success: function (data, textStatus, jqXHR) {
                    if (data == "1") {
                        alert('success');
                        window.location.reload();
                    }
                }});
               
            }
        });
         
         $('#searchmoldcode').change(function(){
             var data="productioncode=" + $('#searchmoldcode').val();
             data=encodeURI(data);
             window.location.replace("?fragment=mold&component=mold&"+data);
         });
          $('#searchmoldcode').typeahead({
            source: function (query, result) {
                $.ajax({
                    url: "views/mold/query/moldcodeautocomplate.php",
                    data: 'productioncode=' + $("#searchmoldcode").val(),
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
        <label for="searchmoldcode">Product Code</label>          
        <input class="form-control" type="text" value="<?php echo $productioncode; ?>" name="searchmoldcode" id="searchmoldcode">
    </div>
   
</div>
<div class="row">
    <table class="table table-condensed">
        <thead>
            <tr>
               
              
                <th>Product Code</th>
                <th>Part Code</th>
                <th>Part Name</th>
                
                <th>Customer</th>
                <th>Tools</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $cout=1;
            if ($productioncode != "") {

                $query = "SELECT * FROM `mold` WHERE `productioncode` like '%$productioncode%' order by id desc ";
                
               
                $result = mysqli_query($connection, $query);
                while ($row1 = mysqli_fetch_array($result)) {
                    ?>
                    <tr>
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
                $query = "SELECT * FROM `mold` WHERE 1  order by id desc  ";
               
                $result = mysqli_query($connection, $query);
                if (mysqli_num_rows($result) > 0) {
                    while ($row2 = mysqli_fetch_array($result)) {
                         if ($start1 < $cout1) {
                            $start1++;
                            continue;
                        }
                        if ($start1 >= $lastname1) {
                            $start1++;
                            continue;
                        }
                       
                        $start1++;
                        
                        
                        ?>
                        <tr>
                           
                           
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
                
                if($productioncode =="" ){
                    $query="SELECT * FROM `mold` WHERE 1";
                }else{
                     $query="SELECT * FROM `mold` WHERE `productioncode` like '%$productioncode%'";
                }
                
                
                
                $result=  mysqli_query($connection, $query);
                $num=  mysqli_num_rows($result)/10;
                $numrow=ceil($num);
                ?>
                <li class="page-item <?php if($page==1){ echo 'disabled';} ?>">
                    <a class="page-link " href="?fragment=mold&component=mold&productioncode=<?php echo $productioncode; ?>&page=<?php echo $page-1; ?>" tabindex="-1">Previous</a>
                </li>
                <?php for($i=1;$i<=$numrow;$i++){   ?>
                <li class="page-item <?php if($page==$i){    echo 'active';} ?>  "><a class="page-link" href="?fragment=mold&component=mold&productioncode=<?php echo $productioncode; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
               
                <?php } ?>
                <li class="page-item <?php if($page>= $numrow){ echo 'disabled';} ?>">
                    <a class="page-link " href="?fragment=mold&component=mold&productioncode=<?php echo $productioncode; ?>&page=<?php echo $page+1; ?>">Next</a>
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
                        <label for="productioncode">Product Code</label>
                        <input type="text" class="form-control" autocomplete="off" id="productioncode" name="productioncode" placeholder="" required="">
                        <div class="invalid-feedback">
                            Please enter your shipping address.
                        </div>
                    </div>
                     <div class="row">
                        <label for="partcode">Part Code</label>
                        <input type="text" class="form-control" autocomplete="off"  id="partcode" name="partcode" placeholder="" required="">
                        <div class="invalid-feedback">
                            Please enter your shipping address.
                        </div>
                    </div>
                    <div class="row">
                        <label for="partname">Part Name</label>
                        <input type="text" class="form-control" autocomplete="off"  id="partname" name="partname" placeholder="" required="">
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