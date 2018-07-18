<script src="../vender/typeahead.js" ></script>
<script >
    $(document).ready(function () {
        $("#adduserbtn").click(function () {
            var dataString = $("#formuser").serialize();
            var  sex = $("#sex").val();
            var  name = $("#name").val();
            var  lastname = $("#lastname").val();
            var  employeeID = $("#employeeID").val();
            var  username = $("#username").val();
            var  password = $("#password").val();
            var  privilege = $("#privilege").val();
            
            if((sex=="")||(name=="")||(lastname=="")||(employeeID=="")||(username=="")||(password=="")||(privilege=="")){
                 alert("กรุณาใส่ค่าให้ครับ");
            }else{
            $.ajax({url: "./views/managementuser/query/adduser.php", cache: false, data: dataString, type: 'POST', success: function (data, textStatus, jqXHR) {
                    if (data == 1) {
                        alert("success");
                        window.location.reload();
                    }

                }});
            
        }
        });


        $('#name1').typeahead({
            source: function (query, result) {
                $.ajax({
                    url: "views/managementuser/query/usernameautocomplate.php",
                    data: 'name=' + $("#name1").val(),
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
            var name = $('#name1').val();
            var p = $('#privilege1').val();
             var filter="";
            if (name != "" || p !="") {
                 filter = "?fragment=user&component=listuser&name=" + name + "&privilege=" + p;
                 
            }else{
                 filter = "?fragment=user&component=listuser";
            }

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
            var employeeID = $("#employeeID" + id).val();

            var dataString = "id=" + id + "&name=" + name + "&lastname=" + lastname + "&username=" + username + "&password=" + password + "&employeeID=" + employeeID;

            $.ajax({data: dataString, type: 'POST', cache: false, url: "views/managementuser/query/ajaxEdit.php", success: function (data, textStatus, jqXHR) {


                    if (data == 1) {

                        window.location.reload();
                    }
                }});

        });

    });
</script>

<div class="row" >
    <table style="width: 100%;" >
        <tr>
            <td ></td>
            <td style="text-align: right;">
                <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#adduser">
                    Add User
                </button>   
            </td>
        </tr>
    </table>
</div>


<div id="adduser" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                Add User
            </div>
            <div class="modal-body"> <form id="formuser" >
                    <div class=" mb-3">
                        <label for="sex">Sex</label>
                        <select name="sex" class="custom-select d-block w-100" id="sex" required="">
                            <option value="">Choose...</option>
                            <option value="0">male </option>
                            <option value="1">female </option>

                        </select>
                        <div class="invalid-feedback">
                            Please select a position.
                        </div>
                    </div>


                    <div class="mb-3">
                        <label for="name">Name</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">@</span>
                            </div>
                            <input type="text" class="form-control" autocomplete="off"  id="name" name="name" placeholder="Name" required="">
                            <div class="invalid-feedback" style="width: 100%;">
                                Your username is required.
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="lastname">Lastname</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">@</span>
                            </div>
                            <input type="text" class="form-control" autocomplete="off"  id="lastname" name="lastname" placeholder="Lastname" required="">
                            <div class="invalid-feedback" style="width: 100%;">
                                Your username is required.
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="employeeID">Employee ID</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">@</span>
                            </div>
                            <input type="text" class="form-control" autocomplete="off"  id="employeeID" name="employeeID" placeholder="Employee ID" required="">
                            <div class="invalid-feedback" style="width: 100%;">
                                Your username is required.
                            </div>
                        </div>
                    </div>



                    <div class="mb-3">
                        <label for="username">Username</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">@</span>
                            </div>
                            <input type="text" class="form-control" autocomplete="off"  id="username" name="username" placeholder="Username" required="">
                            <div class="invalid-feedback" style="width: 100%;">
                                Your username is required.
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">@</span>
                            </div>
                            <input type="password" class="form-control" autocomplete="off"  id="password" name="password" placeholder="Password" required="">
                            <div class="invalid-feedback" style="width: 100%;">
                                Your username is required.
                            </div>
                        </div>
                    </div>

                    <div class=" mb-3">
                        <label for="privilege">Privilege</label>
                        <select name="privilege" class="custom-select d-block w-100" id="privilege" required="">
                            <option value="">Choose...</option>
                            <option value="1">operator</option>
                            <option value="0">technician</option>

                            <option value="2">lineleadder</option>
                            <option value="3">shifleadder</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select a position.
                        </div>
                    </div>

                </form>

            </div>


            <div class="modal-footer">
                <button type="button" id="adduserbtn" class="btn btn-default" data-dismiss="modal">Add</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

        </div>

    </div>
</div>


<?php
$name = isset($_GET['name']) ? $_GET['name'] : "";
$privilege = isset($_GET['privilege']) ? $_GET['privilege'] : "5";
$page = isset($_GET['page']) ? $_GET['page'] : 1;
?>
<div class="row" style="background: buttonhighlight;" >
    <div class="col-md-5 mb-3">
        <label for="name1">Name</label>
        <div class="input-group ">
            <div class="input-group-prepend">
                <span class="input-group-text">@</span>
            </div>
            <input type="text" class="form-control " autocomplete="off"  id="name1" name="name1" value="<?php echo $name; ?>"  placeholder="Name" required="">

        </div>
    </div>
    <div class=" mb-3">
        <label for="privilege1">Privilege</label>
        <select name="privilege1" class="custom-select d-block w-100" id="privilege1" required="">
            <option value="" <?php
            if (intval($privilege) == "5") {
                echo 'selected';
            }
            ?>>Choose...</option>

            <option <?php
            if (intval($privilege) === 1) {
                echo 'selected';
            }
            ?> value="1">operator</option>
            <option <?php
            if (intval($privilege) === 0) {
                echo 'selected';
            }
            ?> value="0">technician</option>
            <option <?php
            if (intval($privilege) === 2) {
                echo 'selected';
            }
            ?> value="2">lineleadder</option>
            <option  <?php
            if (intval($privilege) === 3) {
                echo 'selected';
            }
            ?> value="3">shifleadder</option>
        </select>
        <div class="invalid-feedback">
            Please select a position.
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
            if ($page == 1) {
                $page1 = "0,10";
            } else {
                $page1 = ($page - 1) . "0," . ($page) . "0";
            }

            if ((($name == "") && ($privilege == "5"))) {
                $query = "SELECT * FROM `users` WHERE 1 ORDER BY id DESC limit $page1";
            } else {
                $query = "SELECT * FROM `users` WHERE `name` like '%$name%' and  `privilege`='$privilege'";
            }

            $result = mysqli_query($connection, $query);
            $arrays = array();
            while ($row = mysqli_fetch_array($result)) {
                $arrays[] = $row;
            }
            foreach ($arrays as $row) {
                if ($row['privilege'] == "5") {
                    continue;
                }
                ?>
                <tr>
                    <td><?php echo $row['employeeID']; ?></td>
                    <td><?php
                        if ($row['sex'] == 0) {
                            echo "male";
                        } else {
                            echo "female";
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
    <div class="container">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <?php
                if ($name == "" && $privilege == 5) {
                    $query = "SELECT * FROM `users` WHERE 1";
                } else {
                    $query = "SELECT * FROM `users` WHERE `privilege` = '$privilege' and `name` like '%$name%'  limit $page1  ";
                }

               
                $result = mysqli_query($connection, $query);
                $num = mysqli_num_rows($result) / 10;
                $numrow = ceil($num);
                ?>
                <li class="page-item <?php if ($page == 1) {
                    echo 'disabled';
                } ?>">
                    <a class="page-link " href="?fragment=user&component=listuser&page=<?php echo ($page - 1); ?>&privilege=<?php echo $privilege; ?>" tabindex="-1">Previous</a>
                </li>
                <?php for ($i = 1; $i <= $numrow; $i++) { ?>
                    <li class="page-item <?php if ($page == $i) {
                        echo 'active';
                    } ?>  "><a class="page-link" href="?fragment=user&component=listuser&page=<?php echo ($i); ?>&privilege=<?php echo $privilege; ?>"><?php echo $i; ?></a></li>

<?php } ?>
                <li class="page-item <?php if ($page >= $numrow) {
    echo 'disabled';
} ?>">
                    <a class="page-link " href="?fragment=user&component=listuser&page=<?php echo ($page + 1); ?>&privilege=<?php echo $privilege; ?>">Next</a>
                </li>

            </ul>
        </nav>
    </div>

</div>



