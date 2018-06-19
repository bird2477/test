
<script >
    $(document).ready(function () {
        $('#username').change(function () {
            var dataString = "username=" + $(this).val();
            $.ajax({data: dataString, url: "views/managementuser/query/ajaxCheckUser.php", type: 'POST', cache: false, success: function (data, textStatus, jqXHR) {
                    if (data === 1) {
                        $('#username').val("");
                    }
                }});
        });
    });

</script>


<div class="py-5 text-center">

    <h2>Add User</h2>

</div>

<form class="needs-validation" method="POST" action="./views/managementuser/query/adduser.php" novalidate="">

    <div class="mb-3">
        <label for="name">Name</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">@</span>
            </div>
            <input type="text" class="form-control" id="name" name="name" placeholder="Name" required="">
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
            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Lastname" required="">
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
            <input type="text" class="form-control" id="employeeID" name="employeeID" placeholder="Employee ID" required="">
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
            <input type="text" class="form-control" id="username" name="username" placeholder="Username" required="">
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
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required="">
            <div class="invalid-feedback" style="width: 100%;">
                Your username is required.
            </div>
        </div>
    </div>

    <div class=" mb-3">
        <label for="privilege">Privilege</label>
        <select name="privilege" class="custom-select d-block w-100" id="privilege" required="">
            <option value="">Choose...</option>
            <option value="0">technician</option>
            <option value="1">operator</option>
            <option value="2">lineleadder</option>
            <option value="3">shifleadder</option>
        </select>
        <div class="invalid-feedback">
            Please select a position.
        </div>
    </div>




    <input type="submit" class="btn btn-primary btn-lg btn-block" value="Add" >


</form>