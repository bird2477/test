<?php
$search_param = isset($_GET['search_param']) ? $_GET['search_param'] : "";

?>
<script src="../vender/typeahead.js" ></script>
<script >
    $(document).ready(function () {
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
           
            $.ajax({data: dataString, url: "views/customer/query/ajaxAddCustomer.php", type: 'POST', cache: false, success: function (data, textStatus, jqXHR) {
                    if (data == "1") {
                       alert('success');
                       window.location.reload();
                    }
                }});
        });
        
         $('#search_param').change(function(){
             var data="companynameTH="+$("#search_param").val() +"&companynameEN=" +$('#search_param').val();
             data=encodeURI(data);
             window.location.replace("?fragment=customer&component=listcustomer&"+data);
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
                <th>companynameTH</th>
                <th>companynameEN</th>
                <th>Tools</th>
            </tr>
        </thead>
        <tbody>
            <?php
             $cout=1;
            if ($search_param != "") {

                $query = "SELECT * FROM `customer` WHERE `companynameTH` like '%$search_param%' or `companynameEN` like '%$search_param%'  ";
               
                $result = mysqli_query($connection, $query);
               
                while ($row1 = mysqli_fetch_array($result)) {
                    ?>
                    <tr>
                        <td><?php echo $cout;  ?></td>
                        <td><?php echo $row1['companynameTH']; ?></td>
                            <td><?php echo $row1['companynameEN']; ?></td>
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
                $query = "SELECT * FROM `customer` WHERE 1  order by `id` DESC ";
                $result = mysqli_query($connection, $query);
                if (mysqli_num_rows($result) > 0) {
                    while ($row2 = mysqli_fetch_array($result)) {
                        ?>
                        <tr>
                            <td><?php echo $cout;  ?></td>
                            <td><?php echo $row2['companynameTH']; ?></td>
                            <td><?php echo $row2['companynameEN']; ?></td>
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
                    <input type="text" class="form-control " id="taxno" name="taxno" placeholder="taxno" required="">
                </div>



                <label for="companynameTH">CustomerTH</label>

                <div class="input-group ">
                    <input type="text" class="form-control " id="companynameTH" name="companynameTH" placeholder="companynameTH" required="">
                </div>


                <label for="companynameEN">companynameEN</label>

                <div class="input-group ">
                    <input type="text" class="form-control " id="companynameEN" name="companynameEN" placeholder="companynameEN" required="">
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