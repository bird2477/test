<?php
include '../../../../config/database.php';
session_start();

$id=$_GET['id'];
$query="SELECT * FROM `customer` WHERE `id` = '$id'";
$result=  mysqli_query($connection, $query);
$row=  mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html>
    <head> 
        <link rel="stylesheet" href="../../../../css/bootstrap.css"  crossorigin="anonymous">
        <script src="../../../../js/jquery.min.js" crossorigin="anonymous"></script>
        <script src="../../../../js/bootstrap.js"  crossorigin="anonymous"></script>

        <script >
            $(document).ready(function () {

                $('.chenge').change(function () {
                    var id = $(this).attr("id");
                    var key = $(this).attr("key");
                    var val = $(this).val();
                    var dataString = "id=" + id + "&key=" + key + "&val=" + val;
                    $.ajax({url: "../../customer/query/ajaxChengeCustomer.php", data: dataString, cache: false, type: 'POST', success: function (data, textStatus, jqXHR) {
                            if (data == 1) {
                                alert("update success");
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
                     
                        <a href="../../../?fragment=customer&component=listcustomer&companynameTH=<?php echo urldecode($row['name']); ?>&companynameEN=<?php echo urldecode($row['name']); ?>"  class="btn btn-success " >Back</a>

                    </td>
                </tr>
            </table>
        
            <div class="row" >
                <table class="table">
                    <thead>
                        <tr>
                           
                            <th>Tax No</th>
                            <th>Name</th>
                            <th>Address</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                       
                            <tr>
                              
                              
                                <td>
                                    <input type="text" class="chenge" id="<?php echo $row['id']; ?>" key="taxno" value="<?php echo $row['taxno']; ?>" >
                                </td>
                                <td>
                                    <input type="text" class="chenge" id="<?php echo $row['id']; ?>" key="name" value="<?php echo $row['name']; ?>" >
                                </td>
                                <td>
                                    <input type="text" class="chenge" id="<?php echo $row['id']; ?>" key="address" value="<?php echo $row['address']; ?>" >
                                </td>
                             
                             
                            </tr>       
                     
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>    

