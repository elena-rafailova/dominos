<?php
include_once "main.php";

/** @var \model\Cart $cart */
$cart = $_SESSION["cart"];
if (!$cart->isCartEmpty()) {
    echo "<h1>Shopping cart:</h1>";
    /** @var \model\Product $item */
    foreach ($cart->getProducts() as $item) {
        echo "<p>".$item->getName()."</p>";
    }
    echo "<form action='index.php?target=order&action=finish'>";
    echo "<input type='submit' name='order' value='Order'>";
    echo "</form>";
} else {
    echo "<h1>Your shopping cart is empty!</h1>";
}

