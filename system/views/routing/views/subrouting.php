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


                $(".remove").click(function () {
                    var id = "id=" + $(this).attr("id");
                    $.ajax({data: id, cache: false, url: "../../routing/query/ajaxRemoveSubRouting.php", type: 'POST', success: function (data, textStatus, jqXHR) {
                            if (data == "1") {
                                window.location.reload();
                            }
                        }});
                });
                    
                $('#productionline').change(function(){
                    var id ='id='+ $(this).val();
                    $.ajax({data: id,url: "../../routing/query/ajaxOptionSubproductionline.php",cache: false,type: 'POST',success: function (data, textStatus, jqXHR) {
               
            $('#subproductionline').html(data);
                    }});
                });    
                    
                $("#addmachine").click(function () {
                    var subproductiononline = $("#subproductionline").val();
                    var id = "<?php echo $_GET['id']; ?>";
                    var dataString = "routing=" + id + "&subproductiononline=" + subproductiononline;
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
                        <a href="../../../?fragment=routing&component=routing&productioncode=<?php echo $_GET['productioncode']; ?>&partcode=<?php echo $_GET['partcode']; ?>&partnmae=<?php echo $_GET['partnmae']; ?>"  class="btn btn-success " >Back</a>

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
                                <label for="productionline">Production Line</label>
                                <div class="input-group">

                                    <select name="productionline" class="custom-select d-block w-100" id="productionline" required="">
                                        <option value="">Choose...</option>
                                        <?php
                                        $query="SELECT * FROM `productionline` WHERE 1";
                                        $result=  mysqli_query($connection, $query);
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
                            <th>Tools</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $id = $_GET['id'];
                        $query = "SELECT `subproductionline`.`name`  ,  `subrouting`.`id` FROM `subrouting` INNER JOIN `subproductionline` ON `subrouting`.`subproductiononline`= `subproductionline`.`id` WHERE `routing` = '$id'";
                        $result = mysqli_query($connection, $query);
                        while ($row = mysqli_fetch_array($result)) {
                            ?>
                            <tr>
                                <td><?php echo $row['name']; ?></td>
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

