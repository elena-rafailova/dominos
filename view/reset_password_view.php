
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset your password</title>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

</head>

<body>
<div id='main_header' class='nav navbar'>
<a class='navbar pull-left navbar-left' href='index.php'><img src='./uploads/dominos_logo.svg'></a>
<a href='index.php?target=user&action=main'><button class='navbar btn btn-light'>Back to main </button></a>
</div>
<div class="container center text-center  mb-3">
<h3 class="font-weight-bold text-center text-uppercase">Reset Password</h3>
<form action="index.php?target=user&action=changePassword" method="post">
    <div class="form-group col-md-3  mx-auto" >
        <div class="input-group" >
            <div class="form-group mx-auto">
                <label class="font-weight-bold">New password:</label>
                <input type="password" class="form-control" name="new_password" required placeholder="Enter new password" >
            </div>
            <div class="form-group mx-auto">
                <label class="font-weight-bold">Confirm password:</label>
                <input type="password" class="form-control" name="confirm_password" required placeholder="Confirm password" >
            </div>
        </div>
            <div class="mx-auto" >
                <input type="submit" class="btn btn-primary " name="change_password" value="Reset my password" >
            </div>
</div>
</form>
</div>
</body>
</html>
