<?php

namespace controller;

use model\Cart;
use model\DAO\IngredientDAO;
use model\DAO\OrderDAO;
use model\DAO\OthersDAO;
use model\DAO\PizzaDAO;
use model\Dough;
use model\Ingredient;
use model\Order;
use model\Pizza;
use model\Restaurant;
use model\Size;
use model\User;


define("MIN_QUANTITY", 1);
define("MAX_QUANTITY", 100);
define("STATUS_PENDING", 1);
define("PAYMENT_TYPE_CASH", 1);


class OrderController {

    public function finish() {
        if (isset($_POST["order"])) {
            /** @var Cart $cart */
            $cart = $_SESSION["cart"];
            $user = json_decode($_SESSION['logged_user']);

            if ($cart->isCartEmpty()) {
                die();
            }

            foreach ($cart->getProducts() as $product) {
                if ($product instanceof Pizza && $product->getModified()) {
                    $pizzaDAO = new PizzaDAO();
                    $newPizzaId = $pizzaDAO->addNew($product->getName(), $product->getIngredients());
                    $product->setId($newPizzaId);
                }
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
                $order = new Order(null, $user->id, null, STATUS_PENDING, $delivery_addr, $restaurant_id,
                    PAYMENT_TYPE_CASH, $cart->getPrice(), $cart->getProducts(), null);

                $orderDAO = new OrderDAO();
                $orderDAO->placeOrder($order);
                $_SESSION["cart"] = new Cart();
                //include_once "view/orderStatus.php";
            } else {
                header("Location: index.php?target=pizza&action=showAll");
                die();
            }
        }

    }

//    public function finish() {
//        $pizzaDAO = new PizzaDAO();
//        $orderDAO = new OrderDAO();
//
//        if (isset($_POST["order"])) {
//            if (isset($_POST["pizza_id"]) && isset($_POST["dough"]) && isset($_POST["size"]) && isset($_POST["sauces"])) {
//                $user = json_decode($_SESSION['logged_user']);
//
//                $pizza = $pizzaDAO->getPizza($_POST["pizza_id"]);
//
//                $ingredientsIds = array_merge($_POST["sauces"] ?? [], $_POST["cheeses"] ?? [],
//                    $_POST["herbs"] ?? [], $_POST["meats"] ?? [], $_POST["vegetables"] ?? [], $_POST["miscellaneous"] ?? []);
//
//                $pizzaIngrsIds = [];
//                /** @var Ingredient $ingredient */
//                foreach ($pizza->getIngredients() as $ingredient) {
//                    $pizzaIngrsIds[] = $ingredient->getId();
//                }
//
//                if ($pizzaIngrsIds != $ingredientsIds) {
//                    $ingredients = [];
//                    foreach ($ingredientsIds as $ingredient) {
//                        $ingredientDAO = new IngredientDAO();
//                        $ingredients[] = $ingredientDAO->getById($ingredient);
//                    }
//
//                    $pizza->setIngredients($ingredients);
//                    $pizza->setDough($_POST["dough"]);
//                    $pizza->setSize($_POST["size"]);
//
//                    $newPizzaId = $pizzaDAO->addNew($pizza->getName(), $ingredients);
//                    $pizza->setId($newPizzaId);
//
//                } else {
//                    $pizza->setDough($_POST["dough"]);
//                    $pizza->setSize($_POST["size"]);
//                }
//
//                $price_for_one = 0;
//                if (isset($_POST["price_for_one"])) {
//                    $price_for_one = $_POST["price_for_one"];
//                }
//
//                if (isset($_POST["quantity"]) && $_POST["quantity"] >= MIN_QUANTITY && $_POST["quantity"] <= MAX_QUANTITY) {
//                    $pizza->setQuantity($_POST["quantity"]);
//                } else {
//                    //ToDo error
//                    header("Location: index.php?target=pizza&action=showAll");
//                    die();
//                }
//
//                $delivery_addr = null;
//                if (isset($_SESSION["delivery"])) {
//                    $delivery_addr = $_SESSION["delivery"];
//                }
//
//                $restaurant_id = null;
//                if (isset($_SESSION["carry_out"])) {
//                    $restaurant_id = $_SESSION["carry_out"];
//                }
//
//                if ($restaurant_id || $delivery_addr) {
//                    $order = new Order(null, $user->id, null, STATUS_PENDING, $delivery_addr, $restaurant_id,
//                        PAYMENT_TYPE_CASH, $price_for_one * $_POST["quantity"], [$pizza], null);
//
//                    $orderDAO->placeOrder($order);
//
//                    include_once "view/orderStatus.php";
//                } else {
//                    //ToDo error
//                    header("Location: index.php?target=pizza&action=showAll");
//                    die();
//                }
//            }
//
//            /*others*/
//
//            elseif(isset($_POST["other_id"]) && isset($_POST["category_id"])){
//                $user = json_decode($_SESSION['logged_user']);
//                $id= $_POST["other_id"];
//                $category_id = $_POST["category_id"];
//
//                $user = json_decode($_SESSION['logged_user']);
//                $id= $_POST["other_id"];
//                $category_id = $_POST["category_id"];
//                //todo try catch
//                $othersDAO = new OthersDAO();
//                $other = $othersDAO->getOther($_POST["other_id"],$_POST["category_id"]);
//
//                if (isset($_POST["quantity"]) && $_POST["quantity"] >= MIN_QUANTITY && $_POST["quantity"] <= MAX_QUANTITY) {
//                    $other->setQuantity($_POST["quantity"]);
//                } else {
//                    //ToDo error
//                    header("Location: index.php");
//                    die();
//                }
//
//                $delivery_addr = null;
//                if (isset($_SESSION["delivery"])) {
//                    $delivery_addr = $_SESSION["delivery"];
//                }
//
//                $restaurant_id = null;
//                if (isset($_SESSION["carry_out"])) {
//                    $restaurant_id = $_SESSION["carry_out"];
//                }
//                if ($restaurant_id || $delivery_addr) {
//                    if ($category_id == 8 && isset($_POST["size"])) {
//                        $price_for_one = $_POST["size"];
//                    } else {
//                        $price_for_one = $other->getPrice();
//                    }
//                } else {
//                    //ToDo error
//                    header("Location: index.php?target=pizza&action=showAll");
//                    die();
//                }
//                $order = new Order(null, $user->id, null, STATUS_PENDING, $delivery_addr, $restaurant_id,
//                    PAYMENT_TYPE_CASH, $price_for_one * $_POST["quantity"], [$other], null);
//
//                $orderDAO->placeOrder($order);
//
//                include_once "view/orderStatus.php";
//            }
//        } else {
//            //ToDo error
//            header("Location: index.php?target=pizza&action=showAll");
//            die();
//        }
//    }

}