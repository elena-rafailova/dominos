<?php

namespace controller;

use model\DAO\OthersDAO;
use model\Dough;
use model\Ingredient;
use model\Order;
use model\Pizza;
use model\Restaurant;
use model\Size;
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
                if (!isset($_POST["miscellaneous"])) {
                    $_POST["miscellaneous"] = [];
                }
                $ingredientsIds = array_merge($_POST["sauces"], $_POST["cheeses"], $_POST["herbs"], $_POST["meats"],
                    $_POST["vegetables"], $_POST["miscellaneous"]);

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
                        $ingredients, $price, null, new Dough($_POST["dough"], null, null),
                        new Size($_POST["size"], null, null, null), null);

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
                    //ToDo error
                    header("Location: index.php?target=pizza&action=showAll");
                    die();
                }

                $delivery_addr = null;
                if (isset($_SESSION["delivery"])) {
                    $delivery_addr = $_SESSION["delivery"];
                }

                $restaurant_id = null;
                if (isset($_SESSION["carry_out"])) {
                    $restaurant_id = $_SESSION["carry_out"];
                }
                if ($restaurant_id || $delivery_addr) {
                    $order = new Order(null, $user->id, null, 1, $delivery_addr, $restaurant_id,
                        1, $pizza->getPrice() * $_POST["quantity"], [$pizza], null);
                    $order->placeOrder();

                    include_once "view/orderStatus.php";
                } else {
                    //ToDo error
                    header("Location: index.php?target=pizza&action=showAll");
                    die();
                }
            }
            elseif(isset($_POST["other_id"]) && isset($_POST["category_id"])){
                    $user = json_decode($_SESSION['logged_user']);
                        $id= $_POST["other_id"];
                        $category_id = $_POST["category_id"];
                        //todo try catch
                        $othersDAO = new OthersDAO();
                    $other = $othersDAO->getOther($_POST["other_id"],$_POST["category_id"]);

                if (isset($_POST["quantity"]) && $_POST["quantity"] >= 1 && $_POST["quantity"] <= 100) {
                    $other->setQuantity($_POST["quantity"]);
                } else {
                    //ToDo error
                    header("Location: index.php");
                    die();
                }

                $delivery_addr = null;
                if (isset($_SESSION["delivery"])) {
                    $delivery_addr = $_SESSION["delivery"];
                }

                $restaurant_id = null;
                if (isset($_SESSION["carry_out"])) {
                    $restaurant_id = $_SESSION["carry_out"];
                }
                if ($restaurant_id || $delivery_addr) {
                    if ($category_id == 8 && isset($_POST["size"])) {
                        $price = $_POST["size"];
                    } else {
                        $price = $other->getPrice();
                    }
                } else {
                    //ToDo error
                    header("Location: index.php?target=pizza&action=showAll");
                    die();
                }
                    $order = new Order(null, $user->id, null, 1, $delivery_addr, $restaurant_id,
                        1, $price * $_POST["quantity"], [$other], null);
                    $order->placeOrder();

                    include_once "view/orderStatus.php";
            }
        } else {
            //ToDo error
            header("Location: index.php?target=pizza&action=showAll");
            die();
        }
    }

}