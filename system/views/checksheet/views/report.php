<?php
include '../../../../config/database.php';
session_start();
$checksheetId = isset($_GET['id']) ? $_GET['id'] : "";

$query = "";
?>
<!DOCTYPE html>
<html>
    <head>
        <style >
            .hide{
                visibility: hidden;
            }
        </style>
        <link rel="stylesheet" href="../../../../css/bootstrap.css"  crossorigin="anonymous">
        <script src="../../../../js/jquery.min.js" crossorigin="anonymous"></script>
        <script src="../../../../js/bootstrap.js"  crossorigin="anonymous"></script>
        <script >
            $(document).ready(function () {

                $(".chenge").change(function () {
                    var key = $(this).attr("key");
                    var val = $(this).val();
                    var subproductionlineID = $(this).attr("subproductionlineID");
                    var dataString = "subproductionlineID=" + subproductionlineID + "&key=" + key + "&val=" + val;
                    $.ajax({url: "../../checksheet/query/ajaxUpdateAcutal.php", cache: false, type: 'POST', data: dataString, success: function (data, textStatus, jqXHR) {

                        }});


                });



                $("#send").click(function () {

                    var checksheetId = "checksheetId=<?php echo $checksheetId; ?>";
                    $.ajax({data: checksheetId, url: "../../checksheet/query/ajaxSend.php", cache: false, type: 'POST', success: function (data, textStatus, jqXHR) {
                      
                            window.location.replace("../../../?fragment=checksheet");
                        }});
                });
                data();
                function data() {
                    var checksheetId = "checksheetId=<?php echo $checksheetId; ?>";
                    $.ajax({url: "../../checksheet/query/ajaxLoaddata.php", data: checksheetId, cache: false, type: 'POST', success: function (data, textStatus, jqXHR) {

                            var obj = JSON.parse(data);
                            for (var i in obj) {
                                var key = i;
                                var val = obj[i];
                                for (var j in val) {
                                    var sub_key = j;
                                    var sub_val = val[j];
                                    $("#" + sub_key).text(sub_val);

                                }
                            }

                        }});
                    call1();
                }
                function call1() {
                    setTimeout(function () {
                        data();
                    }, 1000);
                }
                 
                 $(".check").change(function(){
                     var val = $(this).val();
                     var status = $(this).attr("status");
                     var checksheet = $(this).attr("checksheet");
                     var subproductionlineid = $(this).attr("subproductionlineid");
                     var key = $(this).attr("key");
                     var data1="val="+val+"&status="+status+"&checksheet="+checksheet+"&subproductionlineid="+subproductionlineid+"&key="+key;
                    $.ajax({type: 'POST',url: "../../checksheet/query/ajaxCheckUser.php",data: data1,cache: false,success: function (data, textStatus, jqXHR) {
                         window.location.reload();
                       
                    }});
                     
                 });
                 
                 
            });
        </script>
        <meta charset="UTF-8">
    </head>
    <body>
        <div class="container">
            <div class="row" >
                <table style="width: 100%">
                    <tr>
                        <td></td>
                        <td style="text-align: right;">
                            <button type="button" class="btn btn-info "  id="send" >Send Report</button>
                        </td>
                    </tr>
                </table>
            </div>
            <?php
            $query = "SELECT `subchecksheet`.`subproductionlineID`, `subproductionline`.`name`, `subchecksheet`.`target`, `subproductionline`.`actual_total`, `subproductionline`.`free_total`, `subproductionline`.`reject_total`
FROM `subchecksheet`
INNER JOIN `subproductionline` ON  `subchecksheet`.`subproductionlineID`= `subproductionline`.`id` WHERE subchecksheet.checksheet ='$checksheetId'";

            $result = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_array($result)) {
                $subproductionlineID = $row['subproductionlineID'];
                $target = $row['target'];
                $query = "UPDATE `subproductionline` SET   `target`  ='$target' ,`status`='1' WHERE `id` ='$subproductionlineID'";
                mysqli_query($connection, $query);
                ?>

                <div class="panel panel-primary " style="margin: 3px;padding: 3px;"  >           
                    <div class="panel-heading"><h3><?php echo $row['name']; ?></h3></div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Target</th>
                                    <th>Actual Total</th>
                                    <th>Free Total</th>
                                    <th>Reject Total</th>
                                    <th>Tools</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $row['target']; ?></td>
                                    <td  id="actual<?php echo $subproductionlineID; ?>">
                                        <?php echo $row['actual_total']; ?>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control chenge" subproductionlineID="<?php echo $subproductionlineID; ?>" key="free_total" value="<?php echo $row['free_total']; ?>" >
                                    </td>
                                    <td> 
                                        <input type="text" class="form-control chenge" subproductionlineID="<?php echo $subproductionlineID; ?>" key="reject_total" value="<?php echo $row['reject_total']; ?>" >
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group" >
                                            <button type="button" data-toggle="modal" data-target="#<?php echo $subproductionlineID; ?>"  class="btn btn-default">
                                                <?php  
                                                $query="SELECT * FROM `timestamp` WHERE `checksheetID` ='$checksheetId' and `subproductionlineID` ='$subproductionlineID'";
                                                $result1=  mysqli_query($connection, $query);
                                                $mod= mysqli_num_rows($result1) %2;
                                                if($mod){
                                                   
                                                     echo 'Pause'; 
                                                }else{
                                                     echo 'Start';  
                                                }
                                                ?>
                                                
                                            </button>
                                            <a class="btn btn-primary" target="_blank" href="../views/paper.php?subproductionlineID=<?php echo $subproductionlineID; ?>&checksheetId=<?php echo $checksheetId; ?>" >Report</a>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>






                <!-- Modal -->
                <div class="modal fade" id="<?php echo $subproductionlineID; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">เตะบัตร</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="input-group mb-3">   
                                    <input type="text" class="form-control check" status="<?php   if($mod){
                                                    
                                                        echo '0'; 
                                                }else{
                                                  echo '1'; 
                                                } ?>" checksheet="<?php echo $checksheetId; ?>" subproductionlineID="<?php echo $subproductionlineID; ?>"  placeholder="Employee ID" key="employeeID" name="employeeID"   aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="modal-footer">

                            </div>
                        </div>
                    </div>
                </div>





                <?php
            }
            ?>

        </div>
    </body>
</html>    

