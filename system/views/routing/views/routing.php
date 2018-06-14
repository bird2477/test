<script src="../vender/typeahead.js" ></script>
<script >
    $(document).ready(function () {
        $("#routingadd").click(function () {
            var code = $("#code").val();
            var name = $("#name").val();
            var productionline = $("#productionline").val();
            var dataSting = "code=" + code + "&name=" + name + "&productionline=" + productionline;
            $.ajax({data: dataSting, type: 'POST', cache: false, url: "views/routing/query/ajaxAddrouting.php", success: function (data, textStatus, jqXHR) {

                    if (data != "") {
                        window.location.replace(data);
                    }
                }});

        });


        $('#searchcode').typeahead({
            source: function (query, result) {
                $.ajax({
                    url: "views/routing/query/codeautocomplate.php",
                    data: 'code=' + $("#searchcode").val(),
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

        $('#searchname').typeahead({
            source: function (query, result) {
                $.ajax({
                    url: "views/routing/query/nameautocomplate.php",
                    data: 'name=' + $("#searchname").val(),
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
            var searchname = $('#searchname').val();
            var searchcode = $('#searchcode').val();
            var url = "&code=" + searchcode + "&name=" + searchname;
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
                    <label for="code">Code</label>

                    <div class="input-group ">
                        <input type="text" class="form-control " id="code" name="code" placeholder="code : 103322551015" required="">
                    </div>
                </div>
                <div class="row">
                    <label for="name">Name</label>
                    <div class="input-group ">
                        <input type="text" class="form-control " id="name" name="name" placeholder="Description" required="">
                    </div>
                </div>

                <div class="row">
                    <label for="productionline">Production Line</label>       
                    <select name="productionline" class="custom-select d-block w-100 " id="productionline" required="">
                        <option value="">Choose...</option>
                        <?php
                        $query = "SELECT * FROM `productionline` WHERE 1";
                        $result = mysqli_query($connection, $query);
                        while ($row = mysqli_fetch_array($result)) {
                            ?> 
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['machine']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
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
        <label for="searchcode">Code</label>
        <div class="input-group ">
            <input type="text" class="form-control " id="searchcode" name="searchcode" placeholder="Code" required="">

        </div>
    </div>
    <div class="col-md-3 mb-3">
        <label for="searchname">Name</label>
        <div class="input-group ">
            <input type="text" class="form-control " id="searchname" name="searchname" placeholder="Name" required="">

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

                <th>Code</th>
                <th>Name</th>
                <th>Tools</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $code = isset($_GET['code']) ? $_GET['code'] : "";
            $name = isset($_GET['name']) ? $_GET['name'] : "";
            if (($code != "") || ($name != "")) {

                $query = "SELECT * FROM `routing` WHERE `code` like '%$code%'  or `name` like '%$name%'";
                $result = mysqli_query($connection, $query);
                while ($row1 = mysqli_fetch_array($result)) {
                    ?>
                    <tr>
                        <td><?php echo $row1['code']; ?></td>
                        <td><?php echo $row1['name']; ?></td>
                        <td>
                            <a href="./views/routing/views/subrouting.php?id=<?php echo $row1['id']; ?>&productionline=<?php echo $row1['productionline']; ?>&code=<?php echo $_GET['code']; ?>&name=<?php echo $_GET['name']; ?>"  class="btn btn-success " >Sub station</a>
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
                        <td><?php echo $row2['code']; ?></td>
                        <td><?php echo $row2['name']; ?></td>
                        <td>
                            <a href="./views/routing/views/subrouting.php?id=<?php echo $row2['id']; ?>&productionline=<?php echo $row2['productionline']; ?>&code=<?php echo $row2['code']; ?>&name=<?php echo $row2['name']; ?>"  class="btn btn-success " >Sub station</a>
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
                        <td colspan="3"> No data</td>

                    </tr>
        <?php
    }
}
?>
        </tbody>
    </table>
</div>


