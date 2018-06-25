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

                $("#addmachine").click(function () {
                    var dataString = encodeURI($('#formadd').serialize() +"&productionline=<?php echo $_GET['id']; ?>");

                    $.ajax({data: dataString, url: "../../managementmachine/query/ajaxAddSubMachine.php", cache: false, type: 'POST', success: function (data, textStatus, jqXHR) {
                    
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
                    $.ajax({url: "../../managementmachine/query/ajaxChengeSubproductionline.php", data: dataString, cache: false, type: 'POST', success: function (data, textStatus, jqXHR) {
                            if (data == 1) {
                                alert("update success");
                            }
                        }});
                });

                $(".remove").click(function () {
                    var id = "id=" + $(this).attr("id");
                    $.ajax({data: id, cache: false, url: "../../managementmachine/query/ajaxRemoveSub.php", type: 'POST', success: function (data, textStatus, jqXHR) {
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
                        <a href="../../../?fragment=managementmachine&component=lineproduction&id=<?php echo $_GET['id']; ?>"  class="btn btn-success " >Back</a>

                    </td>
                </tr>
            </table>
            <div id="add" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <form  id="formadd" >
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                Sub Machine
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="name">Machine Code</label>
                                    <div class="input-group">

                                        <input type="text" class="form-control" id="name" name="name" placeholder="Machine Code" required="">
                                        <div class="invalid-feedback" style="width: 100%;">
                                            Your username is required.
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="type">Type</label>
                                    <div class="input-group">

                                        <input type="text" class="form-control" id="type" name="type" placeholder="Type" required="">
                                        <div class="invalid-feedback" style="width: 100%;">
                                            Your username is required.
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="capability">Capability</label>
                                    <div class="input-group">

                                        <input type="text" class="form-control" id="capability" name="capability" placeholder="Capability" required="">
                                        <div class="invalid-feedback" style="width: 100%;">
                                            Your username is required.
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="model">Model</label>
                                    <div class="input-group">

                                        <input type="text" class="form-control" id="model" name="model" placeholder="Model" required="">
                                        <div class="invalid-feedback" style="width: 100%;">
                                            Your username is required.
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="brandname">Brand Name</label>
                                    <div class="input-group">

                                        <input type="text" class="form-control" id="brandname"  name="brandname" placeholder="Brand Name" required="">
                                        <div class="invalid-feedback" style="width: 100%;">
                                            Your username is required.
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="areasize">Area Size</label>
                                    <div class="input-group">

                                        <input type="text" class="form-control" id="areasize"  name="areasize" placeholder="Area Size" required="">
                                        <div class="invalid-feedback" style="width: 100%;">
                                            Your username is required.
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="ramsize">Ram Size</label>
                                    <div class="input-group">

                                        <input type="text" class="form-control" id="ramsize"  name="ramsize" placeholder="Ram Size" required="">
                                        <div class="invalid-feedback" style="width: 100%;">
                                            Your username is required.
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="blostersize">Bloster Size</label>
                                    <div class="input-group">

                                        <input type="text" class="form-control" id="blostersize"  name="blostersize" placeholder="Bloster Size" required="">
                                        <div class="invalid-feedback" style="width: 100%;">
                                            Your username is required.
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="slideadj">Slide Adj</label>
                                    <div class="input-group">

                                        <input type="text" class="form-control" id="slideadj"  name="slideadj" placeholder="Slide Adj" required="">
                                        <div class="invalid-feedback" style="width: 100%;">
                                            Your username is required.
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="strokelength">Stroke Length</label>
                                    <div class="input-group">

                                        <input type="text" class="form-control" id="strokelength"  name="strokelength" placeholder="Stroke Length" required="">
                                        <div class="invalid-feedback" style="width: 100%;">
                                            Your username is required.
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="SPM">SPM</label>
                                    <div class="input-group">

                                        <input type="text" class="form-control" id="SPM"  name="SPM" placeholder="SPM" required="">
                                        <div class="invalid-feedback" style="width: 100%;">
                                            Your username is required.
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="volt">Volt</label>
                                    <div class="input-group">

                                        <input type="text" class="form-control" id="volt"  name="volt" placeholder="Volt" required="">
                                        <div class="invalid-feedback" style="width: 100%;">
                                            Your username is required.
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="amp">Amp</label>
                                    <div class="input-group">

                                        <input type="text" class="form-control" id="amp"  name="amp" placeholder="Amp" required="">
                                        <div class="invalid-feedback" style="width: 100%;">
                                            Your username is required.
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="hp">HP</label>
                                    <div class="input-group">

                                        <input type="text" class="form-control" id="hp"  name="hp" placeholder="HP" required="">
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
                    </form>
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
                            <th>Area Size</th>
                            <th>Ram Size</th>
                            <th>Bloster Size</th>
                            <th>Slide Adj</th>
                            <th>Stroke Length</th>
                            <th>SPM</th>
                            <th>Volt</th>
                            <th>Amp</th>
                            <th>HP</th>

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
                                    <input type="text" class="chenge" id="<?php echo $row['id']; ?>" key="areasize" value="<?php echo $row['areasize']; ?>" >
                                </td>
                                <td>
                                    <input type="text" class="chenge" id="<?php echo $row['id']; ?>" key="ramsize" value="<?php echo $row['ramsize']; ?>" >
                                </td>
                                <td>
                                    <input type="text" class="chenge" id="<?php echo $row['id']; ?>" key="blostersize" value="<?php echo $row['blostersize']; ?>" >
                                </td>
                                <td>
                                    <input type="text" class="chenge" id="<?php echo $row['id']; ?>" key="slideadj" value="<?php echo $row['slideadj']; ?>" >
                                </td>
                                <td>
                                    <input type="text" class="chenge" id="<?php echo $row['id']; ?>" key="strokelength" value="<?php echo $row['strokelength']; ?>" >
                                </td>
                                <td>
                                    <input type="text" class="chenge" id="<?php echo $row['id']; ?>" key="SPM" value="<?php echo $row['SPM']; ?>" >
                                </td>
                                <td>
                                    <input type="text" class="chenge" id="<?php echo $row['id']; ?>" key="volt" value="<?php echo $row['volt']; ?>" >
                                </td>
                                <td>
                                    <input type="text" class="chenge" id="<?php echo $row['id']; ?>" key="amp" value="<?php echo $row['amp']; ?>" >
                                </td>
                                <td>
                                    <input type="text" class="chenge" id="<?php echo $row['id']; ?>" key="hp" value="<?php echo $row['hp']; ?>" >
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

