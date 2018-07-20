<?php
$search_param = isset($_GET['companynameTH']) ? $_GET['companynameTH'] : "";
$page = isset($_GET['page']) ? $_GET['page'] : 1;
if ($page == 1) {
    $page1 = "0,10";
    $cout1 = 0;
} else {
    $page1 = ($page - 1) . "0," . ($page) . "0";
    $cout1 = ($page - 1) * 10;
}
?>
<script src="../vender/typeahead.js" ></script>
<script >
    $(document).ready(function () {
        
        $("#name").change(function(){
               var id = "name=" + $(this).val();
            $.ajax({data: id, url: "views/customer/query/check.php", type: 'POST', cache: false, success: function (data, textStatus, jqXHR) {

                    if (data != 0) {
                        $("#name").val("");
                        alert("มีข้อมูลลูกค้าอยู่แล้ว");
                    }
                }});
            
        });
        
        
        $(".remove").click(function () {
            var id = "id=" + $(this).attr("id");
            $.ajax({data: id, url: "views/customer/query/ajaxRemoveCustomer.php", type: 'POST', cache: false, success: function (data, textStatus, jqXHR) {

                    if (data == 1) {
                        window.location.reload();
                    }
                }});

        });

        $("#productionlineadd").click(function () {
            var dataString = $('#custoner').serialize();
            var taxno = $("#taxno").val();
            var name = $("#name").val();
            var address = $("#address").val();
            if ((taxno == "") || (name == "") || (address == "")) {
                alert("กรุณาใส่ค่าให้ครับ");
            } else {


                $.ajax({data: dataString, url: "views/customer/query/ajaxAddCustomer.php", type: 'POST', cache: false, success: function (data, textStatus, jqXHR) {
                        if (data == "1") {
                            alert('success');
                            window.location.reload();
                        }
                    }});
            }
        });

        $('#search_param').change(function () {
            var data = "companynameTH=" + $("#search_param").val() + "&companynameEN=" + $('#search_param').val();
            data = encodeURI(data);
            window.location.replace("?fragment=customer&component=listcustomer&" + data);
        });

        $('#search_param').typeahead({
            source: function (query, result) {
                $.ajax({
                    url: "views/customer/query/nameENautocomplate.php",
                    data: 'search_param=' + $("#search_param").val(),
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
                        console.log(data);
                        result($.map(data, function (item) {

                            return item;
                        }));
                    }
                });
            }
        });


    });
</script>

<div class="row" >
    <table style="width: 100%;" >
        <tr>
            <td ></td>
            <td style="text-align: right;">
                <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#linemachine">
                    Add Customer
                </button>   
            </td>
        </tr>
    </table>
</div>



<div class="row" style="background: buttonhighlight;" >
    <div class="col-md-5 mb-3">
        <label for="search_param">Search</label>          
        <input class="form-control" type="text" value="<?php echo $search_param; ?>" name="search_param" id="search_param">
    </div>



</div>
<div class="row">
    <table class="table table-condensed">
        <thead>
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Address</th>
                <th>Tools</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $cout = 1;
            if ($search_param != "") {

                $query = "SELECT * FROM `customer` WHERE `name` like '%$search_param%'   ";

                $result = mysqli_query($connection, $query);

                while ($row1 = mysqli_fetch_array($result)) {
                    ?>
                    <tr>
                        <td><?php echo $cout; ?></td>
                        <td><?php echo $row1['name']; ?></td>
                        <td><?php echo $row1['address']; ?></td>
                        <td>
                            <a href="./views/customer/views/editcustomer.php?id=<?php echo $row1['id']; ?>"  class="btn btn-success " >Edit Customer</a>
                            <button type="button" class="btn btn-danger remove" id="<?php echo $row1['id']; ?>">
                                Remove
                            </button>   
                        </td>
                    </tr>
                    <?php
                    $cout++;
                }
            } else {
                $query = "SELECT * FROM `customer` WHERE 1  order by `id` DESC  ";
                $lastname1 = ($page) * 10;

                $start1 = 0;
                $result = mysqli_query($connection, $query);
                if (mysqli_num_rows($result) > 0) {
                    while ($row2 = mysqli_fetch_array($result)) {
                        if ($start1 < $cout1) {
                            $start1++;
                            continue;
                        }
                        if ($start1 >= $lastname1) {
                            $start1++;
                            continue;
                        }
                       
                        $start1++;
                        ?>
                        <tr>
                            <td><?php echo $start1; ?></td>
                            <td><?php echo $row2['name']; ?></td>
                            <td><?php echo $row2['address']; ?></td>
                            <td>
                                <a href="./views/customer/views/editcustomer.php?id=<?php echo $row2['id']; ?>"  class="btn btn-success " >Edit Customer</a>
                                <button type="button" class="btn btn-danger remove" id="<?php echo $row2['id']; ?>">
                                    Remove
                                </button>   
                            </td>
                        </tr>
            <?php
            $cout++;
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
    <div class="container">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
<?php
if ($search_param == "") {
    $query = "SELECT * FROM `customer` WHERE 1";
} else {
    $query = "SELECT * FROM `customer` WHERE `name` like '%$search_param%' ";
}



$result = mysqli_query($connection, $query);
$num = mysqli_num_rows($result) / 10;
$numrow = ceil($num);
?>
                <li class="page-item <?php if ($page == 1) {
                    echo 'disabled';
                } ?>">
                    <a class="page-link " href="?fragment=customer&component=listcustomer&companynameTH=<?php echo $search_param; ?>&companynameEN=<?php echo $search_param; ?>&page=<?php echo $page - 1; ?>" tabindex="-1">Previous</a>
                </li>
<?php for ($i = 1; $i <= $numrow; $i++) { ?>
                    <li class="page-item <?php if ($page == $i) {
        echo 'active';
    } ?>  "><a class="page-link" href="?fragment=customer&component=listcustomer&companynameTH=<?php echo $search_param; ?>&companynameEN=<?php echo $search_param; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>

                <?php } ?>
                <li class="page-item <?php if ($page >= $numrow) {
                    echo 'disabled';
                } ?>">
                    <a class="page-link " href="?fragment=customer&component=listcustomer&companynameTH=<?php echo $search_param; ?>&companynameEN=<?php echo $search_param; ?>&page=<?php echo $page + 1; ?>">Next</a>
                </li>

            </ul>
        </nav>
    </div>
</div>




<div id="linemachine" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                Add Customer
            </div>
            <div class="modal-body">
                <form id="custoner" >
                    <label for="taxno">Tax no</label>

                    <div class="input-group ">
                        <input type="text" class="form-control " autocomplete="off"  id="taxno" name="taxno" placeholder="taxno" required="">
                    </div>



                    <label for="name">Name</label>

                    <div class="input-group ">
                        <input type="text" class="form-control " autocomplete="off"  id="name" name="name" placeholder="Name" required="">
                    </div>


                    <label for="address">Address</label>

                    <div class="input-group ">
                        <input type="text" class="form-control " autocomplete="off"  id="address" name="address" placeholder="Address" required="">
                    </div>
            </div>
            </form>

            <div class="modal-footer">
                <button type="button" id="productionlineadd" class="btn btn-default" data-dismiss="modal">Add</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

        </div>

    </div>
</div>