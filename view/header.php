
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dominos</title>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>


    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

</head>
<body>

<div class="float-right m-3">
    <div id="shopping_cart_icon" class="btn btn-default">

    </div>
</div>

<a href="index.php" class="mr-2"><img src="uploads/dominos_logo.svg" class="w-25"></a>

<nav class="navbar navbar-expand-lg navbar-light">
    <button class="navbar-toggler bg-light" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse " id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto ">
            <li class="nav-item">
                <a href="index.php?target=pizza&action=showAll" class="nav-link mr-2 border bg-light rounded">Order</a>
            </li>
            <li class="nav-item">
                <a href="index.php?target=user&action=edit" class="nav-link mr-2 border bg-light rounded">My Profile (edit)</a>
            </li>
            <li class="nav-item">
                <a href="index.php?target=address&action=show" class="nav-link  mr-2  border bg-light rounded">My Addresses</a>
            </li>
            <li class="nav-item">
                <a href="index.php?target=order&action=showOrders&page=1" class="nav-link mr-2  border bg-light rounded">My Orders</a>
            </li>
            <li class="nav-item">
                <a href="index.php?target=user&action=logout" class="nav-link  mr-2  border bg-light rounded">Logout</a>
            </li>
    </div>
</nav>


<!--    <div class="nav navbar ">-->
<!--        <div class="navbar-btn navbar-right">-->
<!--            <a href="index.php"><img src="uploads/dominos_logo.svg"></a>-->
<!--            <a href="index.php?target=pizza&action=showAll"><input type="button" value="Order" class="btn btn-light"></a>-->
<!--            <a href="index.php?target=user&action=edit"><button class="btn btn-light">My Profile (edit) </button></a>-->
<!--            <a href="index.php?target=address&action=show"><button class="btn btn-light">My Addresses</button></a>-->
<!--            <a href="index.php?target=order&action=showOrders"><button class="btn btn-light">My Orders</button></a>-->
<!--            <a href="index.php?target=user&action=logout"><button class="btn btn-light">Logout</button></a>-->
<!--        </div>-->
<!--        <div class="navbar-btn navbar-right">-->
<!--            <div id="shopping_cart_icon" class="btn btn-default">-->
<!--                <p id="sess_var"> --><?php //echo json_encode($_SESSION['cart']); ?><!--</p>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
    <div id="resId"></div>


    <script src="view/js/map.js"></script>
    <script src="view/js/pizzas.js"></script>
    <script src="view/js/others.js"></script>
    <script src="view/js/others.js"></script>
    <script src="view/js/cart.js"></script>
    <script src="view/js/orders.js"></script>
    <script src="view/js/addresses.js"></script>
    <script>checkCart();</script>
</body>
</html>