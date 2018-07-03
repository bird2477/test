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

                        }});
                    call1();
                }
                function call1() {
                    setTimeout(function () {
                        data();
                    }, 1000);
                }
                $(".option").change(function () {
                    var option = $(this).val();
                    var step = $(this).attr("step");
                    var subchecksheet = $(this).attr("subchecksheet");
                    var dataString = "option=" + option + "&step=" + step + "&subchecksheet=" + subchecksheet;

                    $.ajax({url: "../../checksheet/query/chengeOption.php", cache: false, type: 'POST', data: dataString, success: function (data, textStatus, jqXHR) {
                           
                        }});
                });
                $(".check").change(function () {
                    var val = $(this).val();
                    var status = $(this).attr("status");
                    var checksheet = $(this).attr("checksheet");
                    var subproductionlineid = $(this).attr("subproductionlineid");
                    var key = $(this).attr("key");
                    var data1 = "val=" + val + "&status=" + status + "&checksheet=" + checksheet + "&subproductionlineid=" + subproductionlineid + "&key=" + key;
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
                $target=$row['target'];
                $subproductionlineID=$row['subproductionlineID'];
                $query="UPDATE `subproductionline` SET `status` = '1' ,`target` ='$target'  WHERE `id` ='$subproductionlineID'";
               
                mysqli_query($connection, $query);
                ?>
                <div class="row" >
                    Step : <?php echo $row['step']; ?>
                    <table class="table"   >
                        <thead>
                            <tr>
                                <th>Machine</th>
                                <th>Target</th>
                                <th>Actual</th>
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
        <?php }
    }
    ?>
                                    </select>

                                </td>
                                <td ><?php echo $row['target']; ?></td>
                                <td id="actual<?php echo $row['step']; ?>" ></td>
                                <td ><input step="<?php echo $row['step']; ?>"  id="free<?php echo $row['step']; ?>"  ></td>
                                <td ><input step="<?php echo $row['step']; ?>"  id="reject<?php echo $row['step']; ?>"  ></td>
                                <td ><input step="<?php echo $row['step']; ?>"  id="total<?php echo $row['step']; ?>"  ></td>
                                <td >
                                    <a class="btn btn-primary" target="_blank" href="../views/paper.php?subproductionlineID=<?php echo $row['subproductionlineID']; ?>&checksheetId=<?php echo $_GET['id']; ?>" >Report</a>
                                </td>
                            </tr>
                        </tbody>
                    </table> 
                </div> 
    <?php
}
?>
        </div>
    </body>
</html>    

