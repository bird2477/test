

<img class="rounded-circle" style="text-align: center;" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
    
    
    
    
    <form class="needs-validation" method="POST" action="./views/managementuser/query/ajaxEdit.php" novalidate="">
        <input type="hidden" name="id" value="<?php echo $_SESSION['id']; ?>" >
        <input type="hidden" name="profile" value="1" >
        <div class="col-md-10">
            <label for="name">Name</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">@</span>
                </div>
                <input type="text" class="form-control" id="name" value="<?php echo $_SESSION['name']; ?>" name="name" placeholder="Name" required="">
                <div class="invalid-feedback" style="width: 100%;">
                    Your username is required.
                </div>
            </div>
        </div>
        <div class="col-md-10">
            <label for="lastname">Lastname</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">@</span>
                </div>
                <input type="text" class="form-control" id="lastname" value="<?php echo $_SESSION['lastname']; ?>" name="lastname" placeholder="Lastname" required="">
                <div class="invalid-feedback" style="width: 100%;">
                    Your username is required.
                </div>
            </div>
        </div>



        <div class="col-md-10">
            <label for="username">Username</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">@</span>
                </div>
                <input type="text" class="form-control" id="username" value="<?php echo $_SESSION['username']; ?>" name="username" placeholder="Username" required="">
                <div class="invalid-feedback" style="width: 100%;">
                    Your username is required.
                </div>
            </div>
        </div>
        <div class="col-md-10">
            <label for="password">Password</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">@</span>
                </div>
                <input type="password" class="form-control" id="password" value="<?php echo $_SESSION['password']; ?>"  name="password" placeholder="Password" required="">
                <div class="invalid-feedback" style="width: 100%;">
                    Your username is required.
                </div>
            </div>
        </div>

        <input type="submit" class="btn btn-primary btn-lg btn-block" value="Edit" >


    </form>
        
