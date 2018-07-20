<?php
include '../../../../config/database.php';
session_start();
$routing = $_GET['id'];
?>
<!DOCTYPE html>
<html>
    <head> 

        <link rel="stylesheet" href="../../../../css/bootstrap.css"  crossorigin="anonymous">
        <script src="../../../../js/jquery.min.js" crossorigin="anonymous"></script>
        <script src="../../../../js/poper.js"  crossorigin="anonymous"></script>
        <script src="../../../../js/bootstrap.js"  crossorigin="anonymous"></script>
        <script src="../../../../vender/typeahead.js" ></script>
        <script >
            $(document).ready(function () {


                $(".remove").click(function () {
                    var id = "id=" + $(this).attr("id");
                    $.ajax({data: id, cache: false, url: "../../routing/query/ajaxRemoveSubRouting.php", type: 'POST', success: function (data, textStatus, jqXHR) {
                            if (data == "1") {
                                window.location.reload();
                            }
                        }});
                });

                $('.productionline').change(function () {
                    var id = 'id=' + $(this).val();
                    $.ajax({data: id, url: "../../routing/query/ajaxOptionSubproductionline.php", cache: false, type: 'POST', success: function (data, textStatus, jqXHR) {

                            $('.subproductionline').html(data);
                        }});
                });

                $("#product").change(function () {
                    var id = 'productioncode=' + $(this).val();
                    $.ajax({data: id, url: "../../routing/query/ajaxOptionPartName.php", cache: false, type: 'POST', success: function (data, textStatus, jqXHR) {

                            $('#partcode').html(data);
                        }});
                });

                $("#partcode").change(function () {
                    var id = 'partcode=' + $(this).val();
                    $.ajax({data: id, url: "../../routing/query/ajaxOptionpartcode.php", cache: false, type: 'POST', success: function (data, textStatus, jqXHR) {

                            $('#partname').html(data);
                        }});
                });

                $("#partname").change(function () {
                    var id = 'partname=' + $(this).val();
                    $.ajax({data: id, url: "../../routing/query/ajaxOptionproductioncode.php", cache: false, type: 'POST', success: function (data, textStatus, jqXHR) {

                            $('#customer').html(data);
                        }});
                });

              
                
                
                
                $('#product').typeahead({
                    source: function (query, result) {
                       console.log(query);
                        $.ajax({
                            url: "../../routing/query/productioncodeautocomplate.php",
                            data: 'product=' + $("#product").val(),
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

                $("#addmachine").click(function () {
                    if((($("#step").val()=="") || ($('#detail').val()=="")) ){
                        alert("กรุณาใส่ค่าให้ครบ");
                    }else{
                        if( ($("#step").val() <1)){
                            alert('ไม่สามารถใส่ค่าน้อยกว่า1ได้');
                            
                        }else{
                            
                       
                        
                    var dataString = $('#addmachineSub').serialize() + "&routing=<?php echo $_GET['id']; ?>";
                    $.ajax({data: dataString, url: "../../routing/query/ajaxAddSubRouting.php", type: 'POST', cache: false, success: function (data, textStatus, jqXHR) {
                               
                            if (data == 1) {
                                window.location.reload();
                            }else if(data !=""){
                                alert(data);
                         }
                        }});
                    
                     }
                         }
                         
                         
                });
               

            });

        </script>
        <meta charset="UTF-8">
    </head>
    <body>
        <div class="container">
            <table style="width: 100%">
                <tr>
                    <td></td>
                    <td style="text-align: right;">
                        <button type="button" class="btn btn-info " data-toggle="modal" data-target="#add">Add</button>
                        <a href="../../../?fragment=routing&component=routing&lotno=<?php echo $_GET['lotno']; ?>"  class="btn btn-success " >Back</a>

                    </td>
                </tr>
            </table>
            <div id="add" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            Sub Machine
                        </div>

                        <form id="addmachineSub" >

                            <div class="modal-body">
                                <div class="row">
                                    <label for="step">Step</label>
                                    <div class="input-group">
                                        <input type="number" min="1" autocomplete="off" class="form-control" name="step" id="step" placeholder="Step" >
                                    </div>

                                </div>
                                <div class="row">
                                    <label for="detail">Detail</label>
                                    <div class="input-group">
                                        <input type="text" autocomplete="off" class="form-control" name="detail" id="detail" placeholder="Detail" >
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="product">Product Code</label>
                                    <div class="input-group">
                                        <input type="text" autocomplete="off" class="form-control" name="product" id="product" placeholder="Production Code" >
                                    </div>

                                </div>
                                <div class="row">
                                    <label for="partcode">Part Code</label>
                                    <div class="input-group">
                                        <select  class="form-control" name="partcode" id="partcode"  >
                                            <option >Part Code</option>
                                        </select>

                                    </div>

                                </div>
                                <div class="row">
                                    <label for="partname">Part Name</label>
                                    <div class="input-group">
                                        <select  class="form-control" name="partname" id="partname"  >
                                            <option >Part Name</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="customer">Customer</label>
                                    <div class="input-group">
                                        <select  class="form-control" name="customer" id="customer"  >
                                            <option >Customer</option>
                                        </select>
                                    </div>
                                </div>


                            </div>

                        </form>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" id="addmachine" data-dismiss="modal">Add</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row" >
                <table class="table">
                    <thead>
                        <tr>
                            <th>Step</th>

                            <th>Detail</th>

                            <th>Product Code</th>
                            <th>Part Code</th>
                            <th>Part Name</th>
                            <th>Machine Code</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM `subrouting` WHERE  `routing` ='$routing'  ORDER BY `step`  ASC";
                        $result = mysqli_query($connection, $query);
                        while ($row = mysqli_fetch_array($result)) {
                            $listsubproductionline_id = $row['listsubproductionline_id'];
                            ?>
                            <tr>
                                <td colspan="6"></td>
                                <td>
                                    <button type="button" class="btn btn-info " data-toggle="modal" data-target="#addmachine<?php echo $row['step']; ?>">Add machine</button>
                                    <div id="addmachine<?php echo $row['step']; ?>" class="modal fade" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">

                                                    <h4 class="modal-title">Add Machine</h4>
                                                </div>
                                                <form  method="post" action="../../routing/query/ajaxAddlistsubproductionline.php" >
                                                    <?php
                                                    $mold = $row['mold'];
                                                    $query = "SELECT * FROM `mold` WHERE `id` ='$mold'";
                                                    $result1 = mysqli_query($connection, $query);
                                                    $row1 = mysqli_fetch_array($result1);
                                                    ?>
                                                    <input type="hidden" name="target"  value="<?php echo $_GET['target']; ?>" >
                                                    <input type="hidden" name="lotno"  value="<?php echo $_GET['lotno']; ?>" >
                                                    <input type="hidden" value="<?php echo $row['step']; ?>"  name="step" >
                                                    <input type="hidden" value="<?php echo $_GET['id']; ?>"  name="id" >
                                                    <input type="hidden" value="<?php echo $_GET['lotno']; ?>"  name="lotno" >
                                                    <input type="hidden" value="<?php echo $row1['partcode']; ?>"  name="partcode1" >
                                                    <input type="hidden" value="<?php echo $row1['partname']; ?>"  name="partname1" >
                                                    <input type="hidden" value="<?php echo $row1['productioncode']; ?>"  name="productioncode1" >

                                                    <input type="hidden" value="<?php echo $listsubproductionline_id; ?>"  name="listsubproductionline_id" >
                                                    <div class="modal-body">

                                                        <div class="row" >
                                                            <label for="productionline">Production Line</label>
                                                            <select class="custom-select d-block w-100 productionline" name="productionline" step="<?php echo $row['step']; ?>" id="productionline" required="">
                                                                <option value="">Choose...</option>
                                                                <?php
                                                                $query = "SELECT * FROM `productionline` WHERE 1";
                                                                $result1 = mysqli_query($connection, $query);
                                                                while ($row3 = mysqli_fetch_array($result1)) {
                                                                    ?>
                                                                    <option value="<?php echo $row3['id']; ?>"><?php echo $row3['machine']; ?></option>
    <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="row" >

                                                            <label for="subproductionline">Subproduction Line</label>
                                                            <select class="custom-select d-block w-100 subproductionline" name="subproductionline" step="<?php echo $row['step']; ?>" id="subproductionline" required="">
                                                                <option value="">Choose...</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-default ">Add</button>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
    <?php echo $row['step']; ?>
                                </td>

                                <td>
    <?php echo $row['detail']; ?>
                                </td>

                                <td >
    <?php echo $row1['productioncode']; ?>
                                </td>
                                <td >
    <?php echo $row1['partcode']; ?>
                                </td>
                                <td >
    <?php echo $row1['partname']; ?>
                                </td>
                                <td>
                                    <?php
                                    $query = "SELECT * FROM `listsubproductionline` WHERE `id` ='$listsubproductionline_id'";
                                    $result2 = mysqli_query($connection, $query);
                                    $row2 = mysqli_fetch_array($result2);
                                    $json = $row2['json'];
                                    if ($json != "") {
                                        $array = json_decode($json, TRUE);
                                        foreach ($array as $data) {
                                            $productionline = $data['productionline'];
                                            $subproductionline = $data['subproductionline'];
                                            $query = "SELECT * FROM `subproductionline` WHERE `id` ='$subproductionline' and `productionline` ='$productionline'";

                                            $result5 = mysqli_query($connection, $query);
                                            $ro = mysqli_fetch_array($result5);
                                            echo $ro['name'] . "<br>";
                                        }
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>    

