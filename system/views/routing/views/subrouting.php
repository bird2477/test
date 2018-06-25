<?php
include '../../../../config/database.php';
session_start();
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

                $('#productionline').change(function () {
                    var id = 'id=' + $(this).val();
                    $.ajax({data: id, url: "../../routing/query/ajaxOptionSubproductionline.php", cache: false, type: 'POST', success: function (data, textStatus, jqXHR) {

                            $('#subproductionline').html(data);
                        }});
                });
                
                $("#customer").change(function(){
                     var id = 'id=' + $(this).val();
                    $.ajax({data: id, url: "../../routing/query/ajaxOptionMold.php", cache: false, type: 'POST', success: function (data, textStatus, jqXHR) {

                            $('#moldcode').html(data);
                        }});
                });
                
                
                
                $("#addmachine").click(function () {
                    var subproductiononline = $("#subproductionline").val();
                    var id = "<?php echo $_GET['id']; ?>";
                    var mold = $("#moldcode").val();
                    var dataString = "routing=" + id + "&subproductiononline=" + subproductiononline+"&mold="+mold;
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
                        <div class="modal-body">
                            
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
                                            <option value="<?php echo $row1['id']; ?>" ><?php echo $row1['companynameTH']; ?></option>
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

                            
                            <div class="row">
                                <label for="productionline">Production Line</label>
                                <div class="input-group">

                                    <select name="productionline" class="custom-select d-block w-100" id="productionline" required="">
                                        <option value="">Choose...</option>
                                        <?php
                                        $query = "SELECT * FROM `productionline` WHERE 1";
                                        $result = mysqli_query($connection, $query);
                                        while ($row1 = mysqli_fetch_array($result)) {
                                            ?>
                                            <option value="<?php echo $row1['id']; ?>" ><?php echo $row1['machine']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>

                                </div>
                            </div>

                            <div class="row">
                                <label for="subproductionline">Machine Code</label>
                                <div class="input-group">

                                    <select name="subproductionline" class="custom-select d-block w-100" id="subproductionline" required="">
                                        <option value="">Choose...</option>

                                    </select>

                                </div>
                            </div>
                           

                        </div>
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
                            <th>Machine Code</th>
                            <th>Mold No</th>
                            <th>Tools</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $id = $_GET['id'];
                        $query = "SELECT    `subrouting`.`mold`,  `subproductionline`.`name`  ,  `subrouting`.`id` FROM `subrouting` INNER JOIN `subproductionline` ON `subrouting`.`subproductiononline`= `subproductionline`.`id` WHERE `routing` = '$id'";
                        $result = mysqli_query($connection, $query);
                        while ($row = mysqli_fetch_array($result)) {
                            ?>
                            <tr>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php
                                $mold=$row['mold']; 
                                $query="SELECT * FROM `mold` WHERE `id` ='$mold'";
                                $result1=  mysqli_query($connection, $query);
                                
                                $row1=  mysqli_fetch_array($result1);
                                echo $row1['moldcode'];
                                ?></td>
                                <td>
                                    <button type="button" class="btn btn-danger remove" id="<?php echo $row['id']; ?>">
                                        Remove
                                    </button> 

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

