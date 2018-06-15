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
                $(".update").change(function () {
                    var colum = $(this).attr("colum");
                    var id = $(this).attr("id");
                    var val = $(this).val();
                    var dataStrig = "id=" + id + "&colum=" + colum + "&val=" + val;

                    $.ajax({url: "../../machine/query/ajaxEditAddress.php", cache: false, data: dataStrig, type: 'POST', success: function (data, textStatus, jqXHR) {
                            if (data == "1")
                                alert("Update Success");

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

                        <a href="../../../?fragment=machine&component=machine&productionline=<?php echo $_GET['productionline']; ?>"  class="btn btn-success " >Back</a>

                    </td>
                </tr>
            </table>

            <div class="row" >
                <table class="table">
                    <thead>
                        <tr>
                            <th>Machine</th>
                            <th>NO</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $id = $_GET['productionline'];
                        $query = "SELECT * FROM `subproductionline` WHERE `productionline` LIKE '$id'";
                        $result = mysqli_query($connection, $query);
                        while ($row = mysqli_fetch_array($result)) {
                            ?>
                            <tr>
                                <td><?php echo $row['name']; ?></td>
                                <td>
                                    <input type="text" class="update" value="<?php echo $row['no'] ?>" colum="no" id="<?php echo $row['id']; ?>"     >

                                </td>
                                <td>
                                    <input type="text" class="update" value="<?php echo $row['address']; ?>" colum="address" id="<?php echo $row['id']; ?>"     >
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
