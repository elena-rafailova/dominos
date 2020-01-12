<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome!</title>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
</head>
<body>
<div id="main_header" class="nav navbar ">

    <a class="navbar pull-left navbar-left" href="index.php"><img src="uploads/dominos_logo.svg"></a>

    <div class=" navbar-btn pull-right">
        <img class="icons" width="20px" src="uploads/tel.svg"><nbsp> 070012525 </nbsp>
        <input type="button" value="Login" data-toggle="modal" class="btn btn-light" data-target="#login">
        <input type="button" value="Register" data-toggle="modal" class="btn btn-light"  data-target="#register">
    </div>
</div>

<div id="main_img">

</div>

<div id="login" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title w-100 text-center">Login</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center center">
                <form action="index.php?target=user&action=login" method="post">
                    <label class=" w-100 font-weight-bold">Email:</label>
                    <input class="form-control w-50 mx-auto"  type="email" name="email" placeholder="Enter email" required>
                    <br>
                    <label class=" w-100 font-weight-bold" >Password:</label>
                    <input class="form-control w-50 mx-auto " type="password" name="password" placeholder="Enter password" required>
                    <br>
                <h5><small class=" w-100"><a href="index.php?target=user&action=forgotPassword">Forgotten your password? Click here!</a> </small></h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" name="login" value="Login" class="btn btn-primary ">
            </div>
            </form>
        </div>
    </div>
</div>

<div id="register" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title w-100 text-center">Register</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center center">
                <form action="index.php?target=user&action=register" id="register_form" method="post">
                    <label class=" w-100 font-weight-bold">First name: * </label>
                    <input class="form-control w-50 mx-auto " id="first_name" type="text" name="first_name" placeholder="Enter first name"
                           required pattern="[a-zA-Z]+$" title="First name should contain only letters!">
                    <label class=" w-100 font-weight-bold">Last name: * </label>
                    <input class="form-control w-50 mx-auto" id="last_name" type="text" name="last_name" placeholder="Enter last name"
                           required pattern="[a-zA-Z]+$" title="Last name should contain only letters!">
                    <label class=" w-100 font-weight-bold">Email: * </label>
                    <input class="form-control w-50 mx-auto " id="email" type="email" name="email" placeholder="Enter email"
                           required pattern="^[^@]+@[^@]+\.[^@]+$" title="Please enter a valid email address!">
                    <label class=" w-100 font-weight-bold">New password: * </label>
                    <input class="form-control w-50 mx-auto" id="password" type="password" name="password" placeholder="Enter password"
                           required pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&\*]){8,20}"
                           title="Password should be at least 8 characters -
                containing at least one lowercase, one uppercase letter, one digit
                and one special character.">
                    <label class=" w-100 font-weight-bold ">Verify password: * </label>
                    <input class="form-control w-50 mx-auto " id="verify_password" type="password"  name="verify_password" placeholder="Verify password"
                           required pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&\*]){8,20}"
                           title="Please enter the same password as above.">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" name="register" value="Register" class="btn btn-primary ">
            </div>
            </form>
        </div>
    </div>
</div>

<script src="view/js/registerValidation.js"></script>
</body>

