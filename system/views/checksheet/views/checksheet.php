<script src="../vender/typeahead.js" ></script>
<script >
    $(document).ready(function () {
        $("#search").click(function () {
            var from = $("#from").val();
            var to = $("#to").val();
            var url = "?fragment=checksheet&from=" + from + "&to=" + to;
            window.location.replace(url);
        });

        $(".approved").click(function () {
            var id = "id=" + $(this).attr("id") + "&routing=" + $(this).attr("routing");
            $.ajax({type: 'POST', url: "./views/checksheet/query/ajaxApproved.php", cache: false, data: id, success: function (data, textStatus, jqXHR) {
                    if (data == "1") {
                        window.location.reload();
                    }
                }});
        });
        $(".remove").click(function () {
            var id = "id=" + $(this).attr("id") + "&routing=" + $(this).attr("routing");
            $.ajax({type: 'POST', data: id, cache: false, url: "./views/checksheet/query/ajaxRemove.php", success: function (data, textStatus, jqXHR) {

                    if (data == "1") {
                        window.location.reload();
                    }
                }});

        });

        $('#productioncode').typeahead({
            source: function (query, result) {
                $.ajax({
                    url: "views/checksheet/query/productioncodeautocomplate.php",
                    data: 'productioncode=' + $("#productioncode").val(),
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
                        result($.map(data, function (item) {
                            return item;
                        }));
                    }
                });
            }
        });
        $('#productioncode').change(function () {
            var productioncode = 'productioncode=' + $(this).val();

            $.ajax({url: "./views/checksheet/query/ajaxOptionPartCode.php", cache: false, type: 'POST', data: productioncode, success: function (data, textStatus, jqXHR) {

                    $("#partcode").html(data);

                }});

        });
        $('#partcode').change(function () {
            var partcode =$(this).val();
            var productioncode =$('#productioncode').val();
            var dataString ="partcode="+partcode+"&productioncode="+productioncode;

            $.ajax({url: "./views/checksheet/query/ajaxOptionName.php", cache: false, type: 'POST', data: dataString, success: function (data, textStatus, jqXHR) {

                    $("#partname").html(data);

                }});

        });




        $("#addChecksheet").click(function () {
            if ($("#partname").val() != "") {
                
                var productioncode = $("#productioncode").val();
                var partcode = $("#partcode").val();
                var partname = $("#partname").val();
                var target = $('#target').val();
                var dataString = "productioncode="+productioncode+"&partcode="+partcode+"&partname="+partname+"&target="+target;
                $.ajax({data: dataString, type: 'POST', cache: false, url: "./views/checksheet/query/ajaxReport.php", success: function (data, textStatus, jqXHR) {
                        if (data != "") {
                            window.location.replace("./views/checksheet/views/report.php?id=" + data);
                        }
                    }});
            } else {

            }
        });

    });
</script>

<div class="row" >
    <table style="width: 100%;" >
        <tr>
            <td ></td>
            <td style="text-align: right;">
                <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#add">
                    Add
                </button>   
            </td>
        </tr>
    </table>
</div>

<div id="add" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                Production Report
            </div>
            <div class="modal-body">
                <div class="row">
                    <label for="productioncode">Production Code</label>
                    <input type="text" class="form-control" id="productioncode" required="">
                </div>
                <div class="row">
                    <label for="partcode">Part Code</label>       
                    <select name="partcode" class="custom-select d-block w-100 " id="partcode" required="">
                        <option value="">Choose...</option>

                    </select>
                </div>
                <div class="row">
                    <label for="partname">Part Name</label>       
                    <select name="partname" class="custom-select d-block w-100 " id="partname" required="">
                        <option value="">Choose...</option>

                    </select>
                </div>
                <div class="row">
                    <label for="target">Target</label>       
                    <input type="text" class="form-control" id="target" name="target" placeholder="5000" required="">
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" id="addChecksheet" class="btn btn-default" data-dismiss="modal">Add</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<div class="row" style="background: buttonhighlight;" >
    <div class="col-3" >
        <label for="from" class="col-form-label">From</label>
        <input class="form-control" type="date" value="<?php
        if (isset($_GET['from'])) {
            echo $_GET['from'];
        }
        ?>" name="from" id="from">
    </div>
    <div class="col-3" >
        <label for="to" class="col-form-label">To</label>
        <input class="form-control" type="date" value="<?php
        if (isset($_GET['to'])) {
            echo $_GET['to'];
        }
        ?>" name="to" id="to" >
    </div>
    <div class="col-4" style="    margin-top: 7px;">
        <label for="search">Search</label>
        <input type="button" class="form-control filter"  value="Search" id="search" required="">
    </div>
</div>


<div class="row">
    <table class="table table-condensed">
        <thead>
            <tr>
                <th>Date</th>
                <th>
                    Production Code
                </th>
                <th>
                    Part Code
                </th>
                <th>
                    Part Name
                </th>
                <th colspan="2" style="text-align: center;">Tools</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $to = isset($_GET['to']) ? $_GET['to'] : "";
            $from = isset($_GET['from']) ? $_GET['from'] : "";
            if ($to != "" && $from != "") {
                $query = "SELECT  `routing`.`partcode` ,`checksheet`.`date`,`routing`.`productioncode`,  `routing`.`partname` ,`checksheet`.`status` ,`routing` .`id`  as routingid , `checksheet`.`id`
FROM  `checksheet`
INNER JOIN `routing` 
ON `checksheet`.`routing`=  `routing` .`id`     WHERE `checksheet`.`date` BETWEEN  '$from' and '$to'    ORDER by `checksheet`.`id` DESC";

                $result = mysqli_query($connection, $query);
                while ($row1 = mysqli_fetch_array($result)) {
                    ?>
                    <tr>
                        <td><?php echo $row1['date']; ?></td>
                        <td><?php echo $row1['productioncode']; ?></td>
                        <td><?php echo $row1['partcode']; ?></td>
                        <td><?php echo $row1['partname']; ?></td>
                        <td>
                            <?php
                            if (($row1['status'] == 0)) {
                                ?>
                                <a href="./views/checksheet/views/report.php?id=<?php echo $row1['id']; ?>&routing=<?php echo $row1['routingid']; ?>" class="btn btn-success " >Edit</a>
                                <button type="button" class="btn btn-danger remove" routing="<?php echo $row1['routingid']; ?>" id="<?php echo $row1['id']; ?>">
                                    Remove
                                </button>  
                                <?php
                                if ($_SESSION['privilege'] >= 3) {
                                    ?>

                                    <button type="button" class="btn btn-info approved" routing="<?php echo $row1['routingid']; ?>" id="<?php echo $row1['id']; ?>">
                                        Approved
                                    </button>  
                                    <?php
                                }
                            } elseif (($row1['status'] == 1) && ($_SESSION['privilege']) >= 3) {
                                ?>
                                <a href="./views/checksheet/views/report.php?id=<?php echo $row1['id']; ?>" class="btn btn-success " >Edit</a>
                                <button type="button" class="btn btn-danger remove" routing="<?php echo $row1['routingid']; ?>" id="<?php echo $row1['id']; ?>">
                                    Remove
                                </button>  

                                <?php
                            }
                            ?>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Report
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <?php
                                    $id = $row1['id'];
                                    $query = "SELECT * FROM `subchecksheet` WHERE `checksheet` ='$id'";
                                    $result1 = mysqli_query($connection, $query);
                                    while ($row3 = mysqli_fetch_array($result1)) {
                                        $checksheet = $row3['checksheet'];
                                        $subproductionlineID = $row3['subproductionlineID'];
                                        ?>

                                        <a class="dropdown-item " target="_blank"  href="./views/checksheet/views/paper.php?subproductionlineID=<?php echo $subproductionlineID; ?>&checksheetId=<?php echo $checksheet; ?>">
                                            <?php
                                            $query = "SELECT * FROM `subproductionline` WHERE `id` = '$subproductionlineID'";
                                            $result2 = mysqli_query($connection, $query);
                                            $row4 = mysqli_fetch_array($result2);
                                            echo $row4['name'];
                                            ?>
                                        </a> <?php
                                    }
                                    ?>
                                </div>
                            </div>

                        </td>
                    </tr>
                    <?php
                }
            } else {
                $query = "SELECT  `routing`.`partcode`, `checksheet`.`date`,`routing`.`productioncode`,  `routing`.`partname` ,`checksheet`.`status` ,`routing` .`id`  as routingid , `checksheet`.`id`
FROM  `checksheet`
INNER JOIN `routing` 
ON `checksheet`.`routing`=  `routing` .`id`     WHERE 1  ORDER by `checksheet`.`id` DESC LIMIT 0,10";
                $result = mysqli_query($connection, $query);
                if (mysqli_num_rows($result) > 0) {
                    while ($row2 = mysqli_fetch_array($result)) {
                        ?>
                        <tr>
                            <td><?php echo $row2['date']; ?></td>
                            <td><?php echo $row2['productioncode']; ?></td>
                            <td><?php echo $row2['partcode']; ?></td>
                            <td><?php echo $row2['partname']; ?></td>
                            <td>
                                <?php
                                if (($row2['status'] == 0)) {
                                    ?>
                                    <a href="./views/checksheet/views/report.php?id=<?php echo $row2['id']; ?>" class="btn btn-success " >Edit</a>
                                    <button type="button" class="btn btn-danger remove" routing="<?php echo $row2['routingid']; ?>" id="<?php echo $row2['id']; ?>">
                                        Remove
                                    </button>  
                                    <?php
                                    if ($_SESSION['privilege'] >= 3) {
                                        ?>

                                        <button type="button" class="btn btn-info approved" routing="<?php echo $row2['routingid']; ?>" id="<?php echo $row2['id']; ?>">
                                            Approved
                                        </button>  
                                        <?php
                                    }
                                } elseif (($row2['status'] == 1) && ($_SESSION['privilege']) >= 3) {
                                    ?>
                                    <a href="./views/checksheet/views/report.php?id=<?php echo $row2['id']; ?>" class="btn btn-success " >Edit</a>
                                    <button type="button" class="btn btn-danger remove" routing="<?php echo $row2['routingid']; ?>" id="<?php echo $row2['id']; ?>">
                                        Remove
                                    </button>  

                                    <?php
                                }
                                ?>

                            </td>
                            <td>
                                <div class="dropdown col-2">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Report
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <?php
                                        $id = $row2['id'];
                                        $query = "SELECT * FROM `subchecksheet` WHERE `checksheet` ='$id'";
                                        $result1 = mysqli_query($connection, $query);
                                        while ($row3 = mysqli_fetch_array($result1)) {
                                            $checksheet = $row3['checksheet'];
                                            $subproductionlineID = $row3['subproductionlineID'];
                                            ?>

                                            <a class="dropdown-item " target="_blank"  href="./views/checksheet/views/paper.php?subproductionlineID=<?php echo $subproductionlineID; ?>&checksheetId=<?php echo $checksheet; ?>">
                                                <?php
                                                $query = "SELECT * FROM `subproductionline` WHERE `id` = '$subproductionlineID'";
                                                $result2 = mysqli_query($connection, $query);
                                                $row4 = mysqli_fetch_array($result2);
                                                echo $row4['name'];
                                                ?>
                                            </a> <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr style="text-align: center;">
                        <td colspan="6" >No Data</td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>


