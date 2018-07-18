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
        <script src="../../../../js/poper.js"  crossorigin="anonymous"></script>
        <script src="../../../../js/bootstrap.js"  crossorigin="anonymous"></script>
        <script >
            $(document).ready(function () {
                $(".chenge").change(function () {
                    var key = $(this).attr("key");
                    var val = $(this).val();
                    var subproductionlineID = $(this).attr("subproductionlineID");
                    var dataString = "subproductionlineID=" + subproductionlineID + "&key=" + key + "&val=" + val;
                    $.ajax({url: "../../checksheet/query/ajaxUpdateAcutal.php", cache: false, type: 'POST', data: dataString, success: function (data, textStatus, jqXHR) {
                            console.log(data);
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
                            var array = JSON.parse(data);
                            var i = 1;
                            for (var key in array) {
                                $('#actual' + i).text(array[key]["actual" + i]);
                                $('#total' + i).text(array[key]["total" + i]);
                                i++;
                            }
                        }});
                    call1();
                }
                function call1() {
                    setTimeout(function () {
                        data();
                    }, 10000);
                }
                $(".option").change(function () {
                    var option = $(this).val();
                    var step = $(this).attr("step");
                    var subchecksheet = $(this).attr("subchecksheet");
                    var dataString = "option=" + option + "&step=" + step + "&subchecksheet=" + subchecksheet;
                    $.ajax({url: "../../checksheet/query/chengeOption.php", cache: false, type: 'POST', data: dataString, success: function (data, textStatus, jqXHR) {
                            window.location.reload();
                        }});
                });
                $(".check").change(function () {
                    var val = $(this).val();
                    var status = $(this).attr("status");
                    var checksheet = $(this).attr("checksheet");
                    var subchecksheet = $(this).attr("subchecksheet");
                    var subproductionlineid = $(this).attr("subproductionlineid");

                    var data1 = "val=" + val + "&status=" + status + "&checksheet=" + checksheet + "&subproductionlineid=" + subproductionlineid + "&subchecksheet=" + subchecksheet;
                    $.ajax({type: 'POST', url: "../../checksheet/query/ajaxCheckUser.php", data: data1, cache: false, success: function (data, textStatus, jqXHR) {
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
            $id = $_GET['id'];
            $query = "SELECT * FROM `subchecksheet` WHERE `checksheet` ='$id'";
            $result = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_array($result)) {
                $target = $row['target'];
                $subproductionlineID = $row['subproductionlineID'];
                $query = "UPDATE `subproductionline` SET `target` ='$target'  WHERE `id` ='$subproductionlineID'";

                mysqli_query($connection, $query);
                $step = $row['step'];
                $query = "SELECT * FROM `mold` WHERE `id` =(SELECT `mold` FROM `subrouting` WHERE `routing` =(SELECT `routing` FROM `checksheet` WHERE `id` ='$id') and `step` ='$step')";
                $e = mysqli_query($connection, $query);
                $r = mysqli_fetch_array($e);

                $query = "SELECT * FROM `subrouting` WHERE `routing` =(SELECT `routing` FROM `checksheet` WHERE `id` ='$id') and `step` ='$step'";
                $t = mysqli_query($connection, $query);
                $y = mysqli_fetch_array($t);
                ?>
                <div class="row" >
                    Step : <?php echo $row['step'] ?>  Detail: <?php echo $y['detail']; ?>   Product Code : <?php echo $r['productioncode']; ?>  Part Code : <?php echo $r['partcode']; ?>  Part Name : <?php echo $r['partname']; ?>  
                    <table class="table"   >
                        <thead>
                            <tr>
                                <th>Machine</th>
                                <th>Target</th>
                                <th>Actual Goods</th>
                                <th>Free</th>
                                <th>Reject</th>
                                <th>Total</th>
                                <th>Tools</th>
                            </tr>
                        </thead>
                        <tbody >
                            <tr>
                                <td >
                                    <?php
                                    $subproductionlineID = $row['subproductionlineID'];
                                    $query = "SELECT * FROM `subproductionline` WHERE `id` ='$subproductionlineID'";
                                    $result1 = mysqli_query($connection, $query);
                                    $row1 = mysqli_fetch_array($result1);
                                    ?>
                                    <select id="machine" subchecksheet="<?php echo $row['id']; ?>" step="<?php echo $row['step']; ?>" class="option" >

                                        <option value="" >option</option>
                                        <?php
                                        $step = $row['step'];
                                        $subid = $row['id'];
                                        $query = "SELECT `json` FROM `listsubproductionline` WHERE `id` =(SELECT `listsubproductionline_id` FROM `subrouting` WHERE   `step`='$step'   and `routing` =(SELECT `routing`  FROM `checksheet` WHERE `id` =(SELECT `checksheet` FROM `subchecksheet` WHERE `id` ='$subid')))";
                                        $re = mysqli_query($connection, $query);
                                        $json = mysqli_fetch_array($re);
                                        $json = $json['json'];
                                        if ($json != "") {
                                            $array = json_decode($json, TRUE);
                                            foreach ($array as $data) {
                                                ?>
                                                <option <?php
                                                if ($data['subproductionline'] == $subproductionlineID) {
                                                    echo 'selected';
                                                }
                                                ?>  value="<?php echo $data['subproductionline']; ?>" >
                                                        <?php
                                                        $subproductionline = $data['subproductionline'];
                                                        $query = "SELECT * FROM `subproductionline` WHERE `id` ='$subproductionline'";

                                                        $rq = mysqli_query($connection, $query);
                                                        $r = mysqli_fetch_array($rq);
                                                        echo $r['name'];
                                                        ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>

                                </td>
                                <td ><?php echo $row['target']; ?></td>
                                <td id="actual<?php echo $row['step']; ?>" >
                                    <?php
                                    echo $r['actual_total'] - $r['free_total'] - $r['reject_total'];
                                    ?>
                                </td>
                                <td ><input class="chenge" subproductionlineID="<?php echo $subproductionlineID; ?>" key="free_total" step="<?php echo $row['step']; ?>" value="<?php echo $r['free_total']; ?>"  id="free<?php echo $row['step']; ?>"  ></td>
                                <td ><input class="chenge" subproductionlineID="<?php echo $subproductionlineID; ?>" key="reject_total" step="<?php echo $row['step']; ?>" value="<?php echo $r['reject_total']; ?>"  id="reject<?php echo $row['step']; ?>"  ></td>
                                <td step="<?php echo $row['step']; ?>"  id="total<?php echo $row['step']; ?>">
                                    <?php echo $r['actual_total']; ?>
                                </td>
                                <td >
                                    <button type="button" class="btn btn-info " data-toggle="modal" data-target="#<?php echo $row['id']; ?>">
                                        <?php
                                        $query = "SELECT * FROM `timestamp` WHERE `checksheetID` ='$id' and `subproductionlineID` ='$subproductionlineID' and status ='1'";
                                        $res = mysqli_query($connection, $query);
                                        $r = mysqli_fetch_array($res);
                                        if ($r['status'] == 1) {
                                            echo "Stop";
                                        } else {
                                            echo 'Start';
                                        }
                                        ?>

                                    </button>

                                    <a class="btn btn-info" target="_blank" href="../views/paper.php?subproductionlineID=<?php echo $row['subproductionlineID']; ?>&checksheetId=<?php echo $_GET['id']; ?>" >Report</a>
                                </td>
                            </tr>
                        </tbody>
                    </table> 
                </div> 

                <div id="<?php echo $row['id']; ?>" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">

                                <h4 class="modal-title">แตะบัตร</h4>
                            </div>
                            <div class="modal-body">
                                <input  class="check form-control" subchecksheet="<?php echo $row['id']; ?>" subproductionlineid="<?php echo $subproductionlineID; ?>"  checksheet="<?php echo $id; ?>"  status="<?php echo $r['status'] == 1 ? "0" : "1"; ?>"   >
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

