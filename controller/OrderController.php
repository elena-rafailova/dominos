<?php

namespace controller;

use model\Cart;
use model\DAO\OrderDAO;
use model\DAO\PizzaDAO;
use model\Order;
use model\Pizza;


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
                    if (isset($newPizzaId)) {
                        $product->setId($newPizzaId);
                    }
                }
            }

            $delivery_addr = $_SESSION["delivery"] ?? null;
            $restaurant_id = $_SESSION["carry_out"] ?? null;

            if ($restaurant_id || $delivery_addr) {
                $order = new Order(null, $user->id, null, STATUS_PENDING,
                    $delivery_addr, $restaurant_id,PAYMENT_TYPE_CASH, $cart->getPrice(),
                    $cart->getProducts(), null);

                $orderDAO = new OrderDAO();
                $orderDAO->placeOrder($order);
                $_SESSION["cart"] = new Cart();
                include_once "view/orderStatus.php";
            } else {
                header("Location: index.php?target=pizza&action=showAll");
                die();
            }
        }

    }
}