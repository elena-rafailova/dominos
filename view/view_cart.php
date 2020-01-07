<?php
include_once "main.php";

/** @var \model\Cart $cart */
$cart = $_SESSION["cart"];
if (!$cart->isCartEmpty()) {
    echo "<h1>Shopping cart:</h1>";
    /** @var \model\Product $item */
    foreach ($cart->getProducts() as $item) {
        echo "<h2>".$item->getQuantity() . "x". $item->getName()."</h2>";
        /** @var \model\Ingredient $ingredient */
        if ($item instanceof \model\Pizza) {
            foreach ($item->getIngredients() as $ingredient) {
                echo "<p>" . $ingredient->getName() . "</p>";
            }
        }
        echo "<h3>".$item->getPrice()."</h3>";
    }
    echo "<form action='index.php?target=order&action=finish' method='post'>";
    echo "<input type='submit' name='order' value='Order'>";
    echo "</form>";
} else {
    echo "<h1>Your shopping cart is empty!</h1>";
}

