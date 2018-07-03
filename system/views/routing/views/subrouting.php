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

                $("#customer").change(function () {
                    var id = 'id=' + $(this).val();
                    $.ajax({data: id, url: "../../routing/query/ajaxOptionMold.php", cache: false, type: 'POST', success: function (data, textStatus, jqXHR) {

                            $('#moldcode').html(data);
                        }});
                });



                $("#addmachine").click(function () {
                    var dataString = $('#addmachineSub').serialize() + "&routing=<?php echo $_GET['id']; ?>";
                    $.ajax({data: dataString, url: "../../routing/query/ajaxAddSubRouting.php", type: 'POST', cache: false, success: function (data, textStatus, jqXHR) {

                            if (data == 1) {
                                window.location.reload();
                            }
                        }});

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
                        <a href="../../../?fragment=routing&component=routing&productioncode=<?php echo $_GET['productioncode']; ?>&partcode=<?php echo $_GET['partcode']; ?>&partnmae=<?php echo $_GET['partname']; ?>"  class="btn btn-success " >Back</a>

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
                                        <input type="text" class="form-control" name="step" id="step" placeholder="Step" >
                                    </div>

                                </div>
                                <div class="row">
                                    <label for="customer">Customer</label>
                                    <div class="input-group">

                                        <select name="customer" class="custom-select d-block w-100" id="customer" required="">
                                            <option value="">Choose...</option>
                                            <?php
                                            $query = "SELECT * FROM `customer` WHERE 1";
                                            $result = mysqli_query($connection, $query);
                                            while ($row1 = mysqli_fetch_array($result)) {
                                                ?>
                                                <option value="<?php echo $row1['id']; ?>" ><?php echo $row1['name']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="row">
                                    <label for="moldcode">Mold No</label>
                                    <div class="input-group">

                                        <select name="moldcode" class="custom-select d-block w-100" id="moldcode" required="">
                                            <option value="">Choose...</option>

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
                            <th>Mold No</th>
                            <th>Detail</th>
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
                                <td colspan="3"></td>
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

                                                    <input type="hidden" value="<?php echo $row['step']; ?>"  name="step" >
                                                    <input type="hidden" value="<?php echo $_GET['id']; ?>"  name="id" >
                                                    <input type="hidden" value="<?php echo $_GET['partname']; ?>"  name="partname" >
                                                    <input type="hidden" value="<?php echo $_GET['partcode']; ?>"  name="partcode" >
                                                    <input type="hidden" value="<?php echo $_GET['productioncode']; ?>"  name="productioncode" >
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
                                                        <button type="submit" class="btn btn-default ">add</button>
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
                                    <?php
                                    $mold = $row['mold'];
                                    $query = "SELECT * FROM `mold` WHERE `id` ='$mold'";
                                    $result1 = mysqli_query($connection, $query);
                                    $row1 = mysqli_fetch_array($result1);
                                    echo $row1['moldcode'];
                                    ?>
                                </td>
                                <td>
                                    <?php echo $row1['detail']; ?>
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
                                           
                                            $result5=  mysqli_query($connection, $query);
                                            $ro=  mysqli_fetch_array($result5);
                                            echo $ro['name']."<br>";
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

