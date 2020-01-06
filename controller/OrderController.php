<?php

namespace controller;

use model\DAO\IngredientDAO;
use model\DAO\OrderDAO;
use model\DAO\OthersDAO;
use model\DAO\PizzaDAO;
use model\Dough;
use model\Ingredient;
use model\Order;
use model\Others;
use model\Pizza;
use model\Restaurant;
use model\Size;
use model\User;


class OrderController {

    public function finish() {
        $pizzaDAO = new PizzaDAO();
        $orderDAO = new OrderDAO();

        if (isset($_POST["order"])) {
            if (isset($_POST["pizza_id"]) && isset($_POST["dough"]) && isset($_POST["size"]) && isset($_POST["sauces"])) {
                $user = json_decode($_SESSION['logged_user']);

                $pizza = $pizzaDAO->getPizza($_POST["pizza_id"]);

                $ingredientsIds = array_merge($_POST["sauces"] ?? [], $_POST["cheeses"] ?? [],
                    $_POST["herbs"] ?? [], $_POST["meats"] ?? [], $_POST["vegetables"] ?? [], $_POST["miscellaneous"] ?? []);

                $pizzaIngrsIds = [];
                /** @var Ingredient $ingredient */
                foreach ($pizza->getIngredients() as $ingredient) {
                    $pizzaIngrsIds[] = $ingredient->getId();
                }

                if ($pizzaIngrsIds != $ingredientsIds) {
                    $ingredients = [];
                    foreach ($ingredientsIds as $ingredient) {
                        $ingredientDAO = new IngredientDAO();
                        $ingredients[] = $ingredientDAO->getById($ingredient);
                    }

                    $price = 0;
                    foreach ($ingredients as $ingredient) {
                        $price += $ingredient->getPrice();
                    }

                    $pizza->setIngredients($ingredients);
                    $pizza->setDough($_POST["dough"]);
                    $pizza->setSize($_POST["size"]);
                    $pizza->setPrice($price);

                    $newPizzaId = $pizzaDAO->addNew($pizza->getName(), $ingredients);
                    $pizza->setId($newPizzaId);

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

                    $orderDAO->placeOrder($order);

                    include_once "view/orderStatus.php";
                } else {
                    //ToDo error
                    header("Location: index.php?target=pizza&action=showAll");
                    die();
                }
            }

            /*others*/

            elseif(isset($_POST["other_id"]) && isset($_POST["category_id"])){
                $user = json_decode($_SESSION['logged_user']);
                $id= $_POST["other_id"];
                $category_id = $_POST["category_id"];

                $otherDAO= new OthersDAO();
                $other = $otherDAO->getOther($id, $category_id);

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

                $orderDAO->placeOrder($order);

                include_once "view/orderStatus.php";
            }
        } else {
            //ToDo error
            header("Location: index.php?target=pizza&action=showAll");
            die();
        }
    }

}