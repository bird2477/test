<script src="../vender/typeahead.js" ></script>
<?php
$lotno= isset($_GET['lotno']) ? $_GET['lotno'] : "";
$page = isset($_GET['page']) ? $_GET['page'] : 1;

?>
<script >
    $(document).ready(function () {
        $("#routingadd").click(function () {

            var dataSting = $('#formrouting').serialize();
            $.ajax({data: dataSting, type: 'POST', cache: false, url: "views/routing/query/ajaxAddrouting.php", success: function (data, textStatus, jqXHR) {
                      console.log(data);
                    if (data != "") {
                        window.location.replace(data);
                    }
                }});

        });


        $('#searchlotno').typeahead({
            source: function (query, result) {
                $.ajax({
                    url: "views/routing/query/codeautocomplate.php",
                    data: 'lotno=' + $("#searchlotno").val(),
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

     
        $("#search").click(function () {
            var searchpartname = $('#searchlotno').val();
          
            var url = "&lotno=" + searchpartname ;
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
                <form id="formrouting" >
                    <div class="row">
                        <label for="lotno">Lot No.</label>
                        <div class="input-group ">
                            <input type="text" class="form-control " id="lotno" name="lotno" placeholder="Lot No" required="">
                        </div>
                    </div>
                  
                    <div class="row">
                        <label for="target">Target</label>
                        <div class="input-group ">
                            <input type="text" class="form-control " id="target" name="target" placeholder="Target" required="">
                        </div>
                    </div>
                      <div class="row">
                        <label for="deadline">วันที่ต้องส่งของ</label>
                        <div class="input-group ">
                            <input type="date" class="form-control " id="deadline" name="deadline" placeholder="วันที่ต้องส่งของ" required="">
                        </div>
                    </div>

                </form>


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
        <label for="lotno">Lot No.</label>
        <div class="input-group ">
            <input type="text" class="form-control " value="<?php echo $lotno; ?>" id="searchlotno" name="searchlotno" placeholder="Lot No." required="">

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

                <th>Lot No.</th> 
                <th>Target</th>
                <th>Tools</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($page == 1) {
                $page1 = "0,10";
            } else {
                $page1 = ($page - 1) . "0," . ($page) . "0";
            }


            if (($lotno != "")) {

                $query = "SELECT * FROM `routing` WHERE `lotno` like '%$lotno%'  limit $page1";
               
                $result = mysqli_query($connection, $query);
                $arrays = array();
                while ($row1 = mysqli_fetch_array($result)) {
                    $arrays[] = $row1;
                }
                foreach ($arrays as $row1) {
                    ?>
                    <tr>
                        <td><?php echo $row1['lotno']; ?></td>
                       
                        <td><?php echo $row1['target']; ?></td>

                        <td>
                            <a href="./views/routing/views/subrouting.php?id=<?php echo $row1['id']; ?>&lotno=<?php echo $row1['lotno']; ?>"  class="btn btn-success " >Sub station</a>
                            <button type="button" class="btn btn-danger remove" id="<?php echo $row1['id']; ?>">
                                Remove
                            </button>   
                        </td>
                    </tr>
                    <?php
                }
            } else {
                $query = "SELECT * FROM `routing` WHERE 1 ORDER by `id` DESC  limit $page1";
                $result = mysqli_query($connection, $query);
                if (mysqli_num_rows($result) > 0) {
                    while ($row2 = mysqli_fetch_array($result)) {
                        $arrays[] = $row2;
                    }
                    foreach ($arrays as $row2) {
                        ?>
                        <tr>
                            <td><?php echo $row2['lotno']; ?></td>
                           
                            <td><?php echo $row2['target']; ?></td>

                            <td>
                                <a href="./views/routing/views/subrouting.php?id=<?php echo $row2['id']; ?>&lotno=<?php echo $row2['lotno']; ?>"  class="btn btn-success " >Sub station</a>
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
    <div class="container">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <?php
                if ($lotno == "") {
                    $query = "SELECT * FROM `routing` WHERE 1";
                } else {
                    $query = "SELECT * FROM `routing` WHERE `lotno` like '$lotno' ";
                }


                $result = mysqli_query($connection, $query);
                $num = mysqli_num_rows($result) / 10;
                $numrow = ceil($num);
                ?>
                <li class="page-item <?php
                if ($page == 1) {
                    echo 'disabled';
                }
                ?> ">
                    <a class="page-link " href="?fragment=routing&component=routing&lotno=<?php echo $lotno; ?>&page=<?php echo $page - 1; ?>" tabindex="-1">Previous</a>
                </li>
                <?php for ($i = 1; $i <= $numrow; $i++) { ?>
                    <li class="page-item <?php
                    if ($page == $i) {
                        echo 'active';
                    }
                    ?>  "><a class="page-link" href="?fragment=routing&component=routing&lotno=<?php echo $lotno; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>

                <?php } ?>
                <li class="page-item <?php
                if ($page >= $numrow) {
                    echo 'disabled';
                }
                ?>">
                    <a class="page-link " href="?fragment=routing&component=routing&lotno=<?php echo $lotno; ?>&page=<?php echo $page + 1; ?>">Next</a>
                </li>

            </ul>
        </nav>
    </div>
</div>


