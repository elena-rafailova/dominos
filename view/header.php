
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

    <div class="nav navbar ">
        <div class="navbar-btn navbar-right">
            <a href="index.php"><img src="uploads/dominos_logo.svg"></a>
            <a href="index.php?target=pizza&action=showAll"><input type="button" value="Order" class="btn btn-light"></a>
            <a href="index.php?target=user&action=edit"><button class="btn btn-light">My Profile (edit) </button></a>
            <a href="index.php?target=address&action=show"><button class="btn btn-light">My Addresses</button></a>
            <a href="index.php?target=order&action=showOrders"><button class="btn btn-light">My Orders</button></a>
            <a href="index.php?target=user&action=logout"><button class="btn btn-light">Logout</button></a>
        </div>
        <div class="navbar-btn navbar-right">
            <div id="shopping_cart_icon" class="btn btn-default">
                <p id="sess_var"> <?php echo json_encode($_SESSION['cart']); ?></p>
            </div>
        </div>
    </div>
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