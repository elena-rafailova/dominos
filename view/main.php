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
<div class="nav navbar ">

    <a class="navbar pull-left navbar-left" href="index.php"><img src="uploads/dominos_logo.svg"></a>

    <div class=" navbar-btn pull-right">
        <img class="icons" width="20px" src="uploads/tel.svg"><nbsp> 070012525 </nbsp>
        <input type="button" value="Login" data-toggle="modal" class="btn btn-light" data-target="#login">
        <input type="button" value="Register" data-toggle="modal" class="btn btn-light"  data-target="#register">
    </div>
</div>

<div>
    <img width="100%" height="700vh" src="uploads/main.jpg">
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
                    <label class=" w-100 ">Email:</label><br>
                    <input class=" w-50 " type="email" name="email" placeholder="Enter email" required><br>
                    <label class=" w-100" >Password:</label><br>
                    <input class=" w-50 " type="password" name="password" placeholder="Enter password" required><br>
                <h6 class=" w-100 ">Forgotten your password? Click <a href="index.php?target=user&action=forgotPassword">here!</a> </h6>
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
                <form action="index.php?target=user&action=register" method="post">
                    <label class=" w-100 ">First name: * </label><br>
                    <input class=" w-50 " type="text" name="first_name" placeholder="Enter first name" required><br>
                    <label class=" w-100 ">Last name: * </label><br>
                    <input class=" w-50" type="text" name="last_name" placeholder="Enter last name" required><br>
                    <label class=" w-100 ">Email: * </label><br>
                    <input class=" w-50 " type="email" name="email" placeholder="Enter email" required><br>
                    <label class=" w-100 ">New password: * </label><br>
                    <input class=" w-50" type="password" name="password" placeholder="Enter password" required><br>
                    <label class=" w-100 ">Verify password: * </label><br>
                    <input class=" w-50 " type="password"  name="verify_password" placeholder="Verify password" required><br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" name="register" value="Register" class="btn btn-primary ">
            </div>
            </form>
        </div>
    </div>
</div>

</body>

