<?php
include '../../../../config/database.php';
session_start();
?>
<!DOCTYPE html>
<html>
    <head> <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <script >
            $(document).ready(function () {
                $("#addmachine").click(function () {
                    var productionline = "<?php echo $_GET['id']; ?>";
                    var name = $("#name").val();
                    var type = $("#type").val();
                    var capability = $("#capability").val();
                    var model = $("#model").val();
                    var brandname = $("#brandname").val();
                    var dataString = "productionline=" + productionline + "&name=" + name+ "&type=" + type+ "&capability=" + capability+ "&model=" + model+ "&brandname=" + brandname;
                    $.ajax({data: dataString, url: "../../routing/query/ajaxAddSubMachine.php", cache: false, type: 'POST', success: function (data, textStatus, jqXHR) {
                            if (data == 1) {
                                window.location.reload();
                            }
                        }});

                });

                $('.chenge').change(function () {
                    var id = $(this).attr("id");
                    var key = $(this).attr("key");
                    var val = $(this).val();
                    var dataString = "id=" + id + "&key=" + key + "&val=" + val;
                    $.ajax({url: "../../routing/query/ajaxChengeSubproductionline.php", data: dataString, cache: false, type: 'POST', success: function (data, textStatus, jqXHR) {
                            if (data == 1) {
                                alert("update success");
                            }
                        }});
                });

                $(".remove").click(function () {
                    var id = "id=" + $(this).attr("id");
                    $.ajax({data: id, cache: false, url: "../../routing/query/ajaxRemoveSub.php", type: 'POST', success: function (data, textStatus, jqXHR) {
                            if (data == "1") {
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
                        <a href="../../../?fragment=routing&component=lineproduction&id=<?php echo $_GET['id']; ?>"  class="btn btn-success " >Back</a>

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
                            <div class="mb-3">
                                <label for="name">Machine Code</label>
                                <div class="input-group">

                                    <input type="text" class="form-control" id="name" placeholder="Machine Code" required="">
                                    <div class="invalid-feedback" style="width: 100%;">
                                        Your username is required.
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="type">Type</label>
                                <div class="input-group">

                                    <input type="text" class="form-control" id="type" placeholder="Type" required="">
                                    <div class="invalid-feedback" style="width: 100%;">
                                        Your username is required.
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="capability">Capability</label>
                                <div class="input-group">

                                    <input type="text" class="form-control" id="capability" placeholder="Capability" required="">
                                    <div class="invalid-feedback" style="width: 100%;">
                                        Your username is required.
                                    </div>
                                </div>
                            </div>
                              <div class="mb-3">
                                <label for="model">Model</label>
                                <div class="input-group">

                                    <input type="text" class="form-control" id="model" placeholder="Model" required="">
                                    <div class="invalid-feedback" style="width: 100%;">
                                        Your username is required.
                                    </div>
                                </div>
                            </div>
                             <div class="mb-3">
                                <label for="brandname">Brand Name</label>
                                <div class="input-group">

                                    <input type="text" class="form-control" id="brandname" placeholder="Brand Name" required="">
                                    <div class="invalid-feedback" style="width: 100%;">
                                        Your username is required.
                                    </div>
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
                            <th>Type</th>
                            <th>Capability</th>
                            <th>Model</th>
                            <th>Brand Name</th>
                            <th>Tools</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $id = $_GET['id'];
                        $query = "SELECT * FROM `subproductionline` WHERE `productionline` LIKE '$id'";
                        $result = mysqli_query($connection, $query);
                        while ($row = mysqli_fetch_array($result)) {
                            ?>
                            <tr>
                                <td>
                                    <input type="text" class="chenge" id="<?php echo $row['id']; ?>" key="name" value="<?php echo $row['name']; ?>" >
                                </td>
                                <td> 
                                    <input type="text" class="chenge" id="<?php echo $row['id']; ?>" key="type" value="<?php echo $row['type']; ?>" >
                                </td>
                                <td>
                                    <input type="text" class="chenge" id="<?php echo $row['id']; ?>" key="capability" value="<?php echo $row['capability']; ?>" >
                                </td>
                                <td>
                                    <input type="text" class="chenge" id="<?php echo $row['id']; ?>" key="model" value="<?php echo $row['model']; ?>" >
                                </td>
                                <td>
                                    <input type="text" class="chenge" id="<?php echo $row['id']; ?>" key="brandname" value="<?php echo $row['brandname']; ?>" >
                                </td>
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

