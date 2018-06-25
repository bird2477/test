<script src="../vender/typeahead.js" ></script>
<script >
    $(document).ready(function () {
        $('#name').typeahead({
            source: function (query, result) {
                $.ajax({
                    url: "views/managementuser/query/usernameautocomplate.php",
                    data: 'name=' + $("#name").val(),
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

        $(".filter").click(function () {
            var name = $('#name').val();
        
            var filter = "?fragment=user&component=listuser&name=" + name ;
            window.location.replace(filter);

        });

        $(".remove").click(function () {
            var id = "id=" + $(this).attr("id");
            $.ajax({url: "views/managementuser/query/ajaxRemove.php", cache: false, data: id, type: 'POST', success: function (data, textStatus, jqXHR) {
                    if (data == 1) {

                        window.location.reload();
                    }
                }});

        });

        $('.edit').click(function () {

            var id = $(this).attr("id");

            var name = $('#name' + id).val();

            var lastname = $('#lastname' + id).val();
            var username = $('#username' + id).val();
            var password = $('#password' + id).val();
            var employeeID =$("#employeeID"+id).val();

            var dataString = "id=" + id + "&name=" + name + "&lastname=" + lastname + "&username=" + username + "&password=" + password+"&employeeID="+employeeID;

            $.ajax({data: dataString, type: 'POST', cache: false, url: "views/managementuser/query/ajaxEdit.php", success: function (data, textStatus, jqXHR) {


                    if (data == 1) {

                        window.location.reload();
                    }
                }});

        });

    });
</script>
<?php
$name = isset($_GET['name']) ? $_GET['name'] : "";
$lastname = isset($_GET['lastname']) ? $_GET['lastname'] : "";
?>
<div class="row" style="background: buttonhighlight;" >
    <div class="col-md-5 mb-3">
        <label for="name">Name</label>
        <div class="input-group ">
            <div class="input-group-prepend">
                <span class="input-group-text">@</span>
            </div>
            <input type="text" class="form-control " id="name" name="name" value="<?php echo $name; ?>"  placeholder="Name" required="">

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
                <th>Employee ID</th>
                <th>Sex</th>
                <th>Name</th>
                <th>Lastname</th>
                <th>Privilege</th>
                <th>Tools</th>
            </tr>
        </thead>
        <tbody>

            <?php
            if (($name == "")) {
                $query = "SELECT * FROM `users` WHERE 1 ORDER BY id DESC limit 0,10";
            } else {
                $query = "SELECT * FROM `users` WHERE `name` like '%$name%'";
            }
         
            $result = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_array($result)) {
                if ($row['privilege'] == "5") {
                    continue;
                }
                ?>
                <tr>
                    <td><?php echo $row['employeeID']; ?></td>
                    <td><?php   
                    if($row['sex']==0){
                         echo "male" ;
                    }else{
                          echo "female" ;
                    }
                    ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['lastname']; ?></td>
                    <td><?php 
                            switch (intval($row['privilege'])) {
                                case 0:
                                    echo 'technician';
                                    break;
                                case 1:
                                    echo 'operator';
                                    break;
                                case 2:
                                    echo 'lineleadder';
                                    break;
                                case 3:
                                    echo 'shifleadder';
                                    break;
                            }
                    
                    ?></td>
                    <td>
    <?php if ($row['privilege'] < $_SESSION['privilege']) { ?>
                            <button type="button"  class="btn btn-success btn-lg" data-toggle="modal" data-target="#Edit<?php echo $row['id']; ?>">Edit</button>
                            <button type="button" id="<?php echo $row['id']; ?>"  class="remove btn btn-danger btn-lg" data-toggle="modal" data-target="#">Remove</button>
                        <?php } ?>

                    </td>
                </tr>




                <!--Modal -->
            <div id = "Edit<?php echo $row['id']; ?>" class = "modal fade" role = "dialog">
                <div class = "modal-dialog">

                    <!--Modal content-->
                    <div class = "modal-content">
                        <div class = "modal-header">

                            <h4 class = "modal-title">Edit User</h4>
                        </div>
                        <div class = "modal-body">
                            <div class="row">
                                <label for="name<?php echo $row['id']; ?>">Name</label>
                                <div class="input-group ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">@</span>
                                    </div>
                                    <input type="text" class="form-control " value="<?php echo $row['name']; ?>" id="name<?php echo $row['id']; ?>" name="name<?php echo $row['id']; ?>" placeholder="Name" required="">

                                </div>
                            </div>

                            <div class="row">
                                <label for="lastname<?php echo $row['id']; ?>">Lastname</label>
                                <div class="input-group ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">@</span>
                                    </div>
                                    <input type="text" class="form-control " value="<?php echo $row['lastname']; ?>" id="lastname<?php echo $row['id']; ?>" name="lastname<?php echo $row['id']; ?>" placeholder="Name" required="">

                                </div>
                            </div>
                            
                            <div class="row">
                                <label for="employeeID<?php echo $row['id']; ?>">employeeID</label>
                                <div class="input-group ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">@</span>
                                    </div>
                                    <input type="text" class="form-control " value="<?php echo $row['employeeID']; ?>" id="employeeID<?php echo $row['id']; ?>" name="employeeID<?php echo $row['id']; ?>" placeholder="Name" required="">

                                </div>
                            </div>
                            
                            
                            
                            <div class="row">
                                <label for="username<?php echo $row['id']; ?>">Username</label>
                                <div class="input-group ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">@</span>
                                    </div>
                                    <input type="text" class="form-control " value="<?php echo $row['username']; ?>" id="username<?php echo $row['id']; ?>" name="username<?php echo $row['id']; ?>" placeholder="Name" required="">

                                </div>
                            </div>
                            <div class="row">
                                <label for="password<?php echo $row['id']; ?>">Password</label>
                                <div class="input-group ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">@</span>
                                    </div>
                                    <input type="text" class="form-control " value="<?php echo $row['password']; ?>" id="password<?php echo $row['id']; ?>" name="username<?php echo $row['id']; ?>" placeholder="Name" required="">

                                </div>
                            </div>




                        </div>
                        <div class = "modal-footer">
                            <button type = "button" id="<?php echo $row['id']; ?>" class ="edit  btn btn-default" data-dismiss = "modal">Edit</button>
                            <button type = "button"  class =" btn btn-default" data-dismiss = "modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>




    <?php
}
?>
        </tbody>
    </table>
</div>



