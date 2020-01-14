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

<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="w-100 carousel-img" src="uploads/banner1.jpg" alt="First slide">
            <div class="carousel-caption d-none d-md-block">
                <h5><span class="bg-light text-dark p-1 mb-5 shadow-lg rounded">Try our new wholegrain dough</span></h5>
                <p><span class="bg-light text-dark p-1 mb-5 shadow-lg rounded">Order NOW medium size pizza italian style!</span></p>
            </div>
        </div>
        <div class="carousel-item">
            <img class="w-100" src="uploads/banner2.jpg" alt="Second slide">
            <div class="carousel-caption d-none d-md-block">
                <h5><span class="bg-light text-dark p-1 mb-5 shadow-lg rounded">Try our bestseller</span></h5>
                <p><span class="bg-light text-dark p-1 mb-5 shadow-lg rounded">The vegetarian Pizza Beyond!</span></p>
            </div>
        </div>
        <div class="carousel-item">
            <img class=" w-100" src="uploads/banner3.jpg" alt="Third slide">
            <div class="carousel-caption d-none d-md-block">
                <h5><span class="bg-light text-dark p-1 mb-5 shadow-lg rounded">Our new dough with Philadelphia</span></h5>
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>


<div id="login" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title w-100 text-center">Login</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center center">
                <div id="user_exists"></div>
                <form action="index.php?target=user&action=login" method="post">
                    <label class=" w-100 font-weight-bold">Email:</label>
                    <input class="form-control w-50 mx-auto" id="login_email" type="email" name="email" placeholder="Enter email" required>
                    <br>
                    <label class=" w-100 font-weight-bold" >Password:</label>
                    <input class="form-control w-50 mx-auto " type="password" name="password" placeholder="Enter password" required>
                    <br>
                    <h5><small class=" w-100"><a href="#forgot_password" data-dismiss="modal" data-toggle="modal" >
                                Forgotten your password? Click here!</a> </small></h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" id="login_button" name="login" value="Login" class="btn btn-primary ">
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
                <div id="email_exists" ></div>
                <form action="index.php?target=user&action=register" id="register_form" method="post">
                    <label class=" w-100 font-weight-bold">First name: * </label>
                    <input class="form-control w-50 mx-auto " id="first_name" type="text" name="first_name" placeholder="Enter first name"
                           required pattern="[a-zA-Z\u0400-\u04ff]{3,30}" title="First name should contain only letters, at least 3!">
                    <label class=" w-100 font-weight-bold">Last name: * </label>
                    <input class="form-control w-50 mx-auto" id="last_name" type="text" name="last_name" placeholder="Enter last name"
                           required pattern="[a-zA-Z\u0400-\u04ff]{3,30}" title="Last name should contain only letters,at least 3!">
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
                <input type="submit" name="register" id="register_button" value="Register" class="btn btn-primary ">
            </div>
            </form>
        </div>
    </div>
</div>

<div id="forgot_password" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title w-100 text-center">Forgot Password</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center center">
                <p>Please enter your email so we can assist you in resetting your password.</p>
                <form action="" id="forgot_form" method="post">
                    <label class=" w-100 font-weight-bold">Email:</label>
                    <input class="form-control w-50 mx-auto" id="forgot_email" type="email" name="forgot_email" placeholder="Enter email" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit"  name="forgot_password" value="Send an email" onclick="forgotPass();"
                       class="btn btn-primary ">
            </div>
            </form>
        </div>
    </div>
</div>


<script src="view/js/userValidation.js"></script>

</body>
</html>
