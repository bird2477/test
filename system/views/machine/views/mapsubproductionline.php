<?php
include '../../../../config/database.php';
session_start();
?>
<!DOCTYPE html>
<html>
    <head> <link rel="stylesheet" href="../../../../css/bootstrap.css"  crossorigin="anonymous">
        <script src="../../../../js/jquery.min.js" crossorigin="anonymous"></script>
        <script src="../../../../js/bootstrap.js"  crossorigin="anonymous"></script>

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
                            <th>Machine Code</th>
                            <th>Brand Name</th>
                            <th>Model</th>
                            <th>Type</th>
                            <th>Capability</th>
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
                                <td><?php echo $row['brandname']; ?></td>
                                <td><?php echo $row['model']; ?></td>
                                <td><?php echo $row['type']; ?></td>
                                <td><?php echo $row['capability']; ?></td>
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

