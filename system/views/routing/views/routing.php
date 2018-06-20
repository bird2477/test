<script src="../vender/typeahead.js" ></script>
<script >
    $(document).ready(function () {
        $("#routingadd").click(function () {
            var productioncode = $("#productioncode").val();
            var partname = $("#partname").val();
            var partcode = $("#partcode").val();
           
            var dataSting = "productioncode=" + productioncode + "&partname=" + partname+"&partcode=" + partcode;
            $.ajax({data: dataSting, type: 'POST', cache: false, url: "views/routing/query/ajaxAddrouting.php", success: function (data, textStatus, jqXHR) {

                    if (data != "") {
                        window.location.replace(data);
                    }
                }});

        });


        $('#searchproductioncode').typeahead({
            source: function (query, result) {
                $.ajax({
                    url: "views/routing/query/codeautocomplate.php",
                    data: 'productioncode=' + $("#searchproductioncode").val(),
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
        $('.remove').click(function () {
            var id = "id=" + $(this).attr("id");
            $.ajax({type: 'POST', data: id, cache: false, url: "views/routing/query/ajaxRemoveRouting.php", success: function (data, textStatus, jqXHR) {
                    if (data == 1) {
                        window.location.reload();
                    }
                }});

        });

        $('#searchpartcode').typeahead({
            source: function (query, result) {
                $.ajax({
                    url: "views/routing/query/partcodeautocomplate.php",
                    data: 'searchpartcode=' + $("#searchpartcode").val(),
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
        $('#searchpartname').typeahead({
            source: function (query, result) {
                $.ajax({
                    url: "views/routing/query/nameautocomplate.php",
                    data: 'searchpartname=' + $("#searchpartname").val(),
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

        $("#search").click(function () {
            var searchpartname = $('#searchpartname').val();
            var searchpartcode = $('#searchpartcode').val();
            var searchcode = $('#searchcode').val();
            var url = "&searchpartname=" + searchpartname + "&searchpartcode=" + searchpartcode+ "&searchproductioncode=" + searchproductioncode;
            window.location.replace("?fragment=routing&component=routing" + url);
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
                Routing
            </div>
            <div class="modal-body">
                <div class="row">
                    <label for="productioncode">Production Code</label>

                    <div class="input-group ">
                        <input type="text" class="form-control " id="productioncode" name="productioncode" placeholder="Production Code : 103322551015" required="">
                    </div>
                </div>
                <div class="row">
                    <label for="partcode">Part Code</label>
                    <div class="input-group ">
                        <input type="text" class="form-control " id="partcode" name="partcode" placeholder="Part Code :0010039N" required="">
                    </div>
                </div>
                 <div class="row">
                    <label for="partname">Part Name</label>
                    <div class="input-group ">
                        <input type="text" class="form-control " id="partname" name="partname" placeholder="Part Name :Detial" required="">
                    </div>
                </div>

               

            </div>
            <div class="modal-footer">
                <button type="button" id="routingadd" class="btn btn-default" data-dismiss="modal">Add</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<div class="row" style="background: buttonhighlight;" >
    <div class="col-md-3 mb-3">
        <label for="searchproductioncode">Production Code</label>
        <div class="input-group ">
            <input type="text" class="form-control " id="searchproductioncode" name="searchproductioncode" placeholder="Production Code" required="">

        </div>
    </div>
    <div class="col-md-3 mb-3">
        <label for="searchpartcode">Part Code</label>
        <div class="input-group ">
            <input type="text" class="form-control " id="searchpartcode" name="searchpartcode" placeholder="Part Code" required="">

        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <label for="searchpartname">Part Name</label>
        <div class="input-group ">
            <input type="text" class="form-control " id="searchpartname" name="searchpartname" placeholder="Part Code" required="">

        </div>
    </div>

    <div class="col-md-3 mb-3">
        <label for="search">Search</label>
        <input type="button" class="form-control filter"  value="Search" id="search" placeholder="Search" required="">
        <div class="invalid-feedback">
            search required.
        </div>
    </div>


</div>


<div class="row">
    <table class="table table-condensed">
        <thead>
            <tr>

                <th>Production Code</th>
                <th>Part Code</th>
                <th>Part Name</th>
                <th>Tools</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $partcode = isset($_GET['partcode']) ? $_GET['partcode'] : "";
            $partname= isset($_GET['partname']) ? $_GET['partname'] : "";
            $productioncode = isset($_GET['productioncode']) ? $_GET['productioncode'] : "";
            if (($productioncode != "") || ($partname != "") ||($partcode != "")) {

                $query = "SELECT * FROM `routing` WHERE `productioncode` like '%$productioncode%' or `partcode` like '%$partcode%' or `partname`  like '%$partname%'";
              
                $result = mysqli_query($connection, $query);
                while ($row1 = mysqli_fetch_array($result)) {
                    ?>
                    <tr>
                        <td><?php echo $row1['productioncode']; ?></td>
                        <td><?php echo $row1['partcode']; ?></td>
                        <td><?php echo $row1['partname']; ?></td>
                        <td>
                            <a href="./views/routing/views/subrouting.php?id=<?php echo $row1['id']; ?>&productioncode=<?php echo $row1['productioncode']; ?>&partname=<?php echo $row1['partname']; ?>&partcode=<?php echo $row1['partcode']; ?>"  class="btn btn-success " >Sub station</a>
                            <button type="button" class="btn btn-danger remove" id="<?php echo $row1['id']; ?>">
                                Remove
                            </button>   
                        </td>
                    </tr>
                    <?php
                }
            } else {
                $query = "SELECT * FROM `routing` WHERE 1 ORDER by `id` DESC";
                $result = mysqli_query($connection, $query);
                if (mysqli_num_rows($result) > 0) {
                    while ($row2 = mysqli_fetch_array($result)) {
                        ?>
                     <tr>
                        <td><?php echo $row2['productioncode']; ?></td>
                        <td><?php echo $row2['partcode']; ?></td>
                        <td><?php echo $row2['partname']; ?></td>
                        <td>
                            <a href="./views/routing/views/subrouting.php?id=<?php echo $row2['id']; ?>&productioncode=<?php echo $row2['productioncode']; ?>&partcode=<?php echo $row2['partcode']; ?>&partname=<?php echo $row2['partname']; ?>"  class="btn btn-success " >Sub station</a>
                            <button type="button" class="btn btn-danger remove" id="<?php echo $row2['id']; ?>">
                                Remove
                            </button>   
                        </td>
                    </tr>
                    <?php
                    }
                } else {
                    ?>
                    <tr style="text-align: center;">
                        <td colspan="4"> No data</td>

                    </tr>
        <?php
    }
}
?>
        </tbody>
    </table>
</div>


