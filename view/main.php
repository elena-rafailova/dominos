<?php

echo " Hello, you are in the main page, ";
$user = json_decode($_SESSION['logged_user']);
echo $user->first_name."<br>";
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
    <a href="index.php?target=pizza&action=showAll"><input type="button" value="Order"></a>
    <!--<a href="index.php?target=restaurant&action=show"><button>Restaurants</button></a>-->
    <ul id="buttons">
        <li><a href="index.php?target=user&action=edit"><button>My Profile (edit) </button></a></li>
        <li><a href="index.php?target=address&action=show"><button>My Addresses</button></a></li>
        <li><a href="index.php?target=order&action=showOrders"><button>My Orders</button></a></li>
        <li><a href="index.php?target=user&action=logout"><button>Logout</button></a></li>
    </ul>
    <br><br>


    <div id="shopping_cart_icon">
        <p id="sess_var"> <?php echo json_encode($_SESSION['cart']); ?></p>
    </div>

    <script src="view/js/map.js"></script>
    <script src="view/js/pizzas-view.js"></script>
    <script src="view/js/others-view.js"></script>
    <script src="view/js/cart.js"></script>
    <script src="view/js/orders.js"></script>
    <script>checkCart();</script>
</body>
</html>