<?php

namespace controller;

use model\Ingredient;
use model\Order;
use model\Pizza;
use model\User;


class OrderController {
    public function finish() {
        if (isset($_POST["order"])) {
            if (isset($_POST["pizza_id"]) && isset($_POST["dough"]) && isset($_POST["size"]) && isset($_POST["sauces"])) {
                $user = json_decode($_SESSION['logged_user']);

                $pizza = Pizza::getPizzaById($_POST["pizza_id"]);

                if (!isset($_POST["herbs"])) {
                    $_POST["herbs"] = [];
                }
                if (!isset($_POST["sauces"])) {
                    $_POST["sauces"] = [];
                }
                if (!isset($_POST["cheeses"])) {
                    $_POST["cheeses"] = [];
                }
                if (!isset($_POST["meats"])) {
                    $_POST["meats"] = [];
                }
                if (!isset($_POST["vegetables"])) {
                    $_POST["vegetables"] = [];
                }
                if (!isset($_POST["mixed"])) {
                    $_POST["mixed"] = [];
                }
                $ingredientsIds = array_merge($_POST["sauces"], $_POST["cheeses"], $_POST["herbs"], $_POST["meats"],
                    $_POST["vegetables"], $_POST["mixed"]);

                $pizzaIngrsIds = [];
                /** @var Ingredient $ingredient */
                foreach ($pizza->getIngredients() as $ingredient) {
                    $pizzaIngrsIds[] = $ingredient->getId();
                }

                if ($pizzaIngrsIds != $ingredientsIds) {
                    $ingredients = [];
                    foreach ($ingredientsIds as $ingredient) {
                        $ingredients[] = Ingredient::getIngredientById($ingredient);
                    }

                    $price = 0;
                    foreach ($ingredients as $ingredient) {
                        $price += $ingredient->getPrice();
                    }
                    $newPizzaId = Pizza::addNew($pizza->getName(), $ingredients);
                    $pizza = new Pizza($newPizzaId, $pizza->getName(), null,1,
                        $ingredients, $price, null, $_POST["dough"], $_POST["size"], null);

                } else {
                    $price = 0;
                    /** @var Ingredient $ingredient */
                    foreach ($pizza->getIngredients() as $ingredient) {
                        $price+= $ingredient->getPrice();
                    }
                    $pizza->setDough($_POST["dough"]);
                    $pizza->setSize($_POST["size"]);
                }

                $price += $pizza->getDoughAndSizePrice();
                $pizza->setPrice($price);

                if (isset($_POST["quantity"]) && $_POST["quantity"] >= 1 && $_POST["quantity"] <= 100) {
                    $pizza->setQuantity($_POST["quantity"]);
                } else {
                    header("Location: index.php?target=pizza&action=showAll");
                }

                $order = new Order(null, $user->id, null, 1, null, null,
                    1, $pizza->getPrice() * $_POST["quantity"], [$pizza], null);
                $order->placeOrder();
            }
        } else {
            header("Location: index.php?target=pizza&action=showAll");
        }
    }
}