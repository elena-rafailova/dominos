<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Main</title>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<!--    <div class="nav navbar ">-->
<!--        <div class="navbar-btn navbar-right">-->
<!--            <a href="index.php?target=pizza&action=showAll"><input type="button" value="Order"  class="btn btn-default"></a>-->
<!--            <a href="index.php?target=user&action=edit"><button class="btn btn-default">My Profile (edit) </button></a>-->
<!--            <a href="index.php?target=address&action=show"><button class="btn btn-default">My Addresses</button></a>-->
<!--            <a href="index.php?target=order&action=showOrders"><button class="btn btn-default">My Orders</button></a>-->
<!--            <a href="index.php?target=user&action=logout"><button class="btn btn-default">Logout</button></a>-->
<!--        </div>-->
<!--        <div class="navbar-btn navbar-right">-->
<!--            <div id="shopping_cart_icon" class="btn btn-default">-->
<!--                <p id="sess_var"> --><?php //echo json_encode($_SESSION['cart']); ?><!--</p>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <br><br>-->




    <script src="view/js/pizzas-view.js"></script>
    <script src="view/js/others-view.js"></script>
    <script src="view/js/cart.js"></script>
    <script src="view/js/orders.js"></script>
    <script>checkCart();</script>
    <script src="view/js/map.js"></script>
</body>
</html>