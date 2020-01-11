<?php

namespace controller;

use model\Cart;
use model\DAO\OrderDAO;
use model\DAO\PizzaDAO;
use model\Order;
use model\Other;
use model\Pizza;
use model\Product;


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
                header("Location: index.php?target=cart&action=seeCart&finish");
                //include_once "view/finished_order_view.php";
            } else {
                header("Location: index.php?target=cart&action=seeCart");
                die();
            }
        }

    }

    function showOrders()
    {
        include_once "view/order_history_view.php";
    }

    function getOrders()
    {
        $user_id = json_decode($_SESSION['logged_user'])->id;
        $orderDAO = new OrderDAO();
        $orders = $orderDAO->getOrders($user_id);
        $counts = array_count_values(array_column($orders, "id"));
        $orderArray = [];

        /** @var Order $order */
        foreach ($orders as $order) {
            $isAlreadyThere = false;
            /** @var Order $res */
            foreach ($orderArray as $key => $res) {
                if ($res->getId() == $order->getId()) {
                    $isAlreadyThere = $key;
                    break;
                }
            }
            if ($isAlreadyThere === false) {
                $orderArray[] = $order;
            } else {
                $items = $orderArray[$isAlreadyThere]->getItems();
                foreach ($order->getItems() as $product) {
                    $items[] = $product;
                }
                $orderArray[$isAlreadyThere]->setItems($items);
            }
        }

        usort($orderArray, array("controller\\OrderController", "date_sort"));
        $result = [];
        /** @var Order $order */
        foreach ($orderArray as $order) {
            $productsArray = [];
            foreach ($order->getItems() as $item) {
                if ($item instanceof Pizza) {
                    $productsArray[] = $item->getQuantity() . "x " . $item->getSize()->getName() . " " .  $item->getDough()->getName() . " " .$item->getName();
                } else if ($item instanceof Other) {
                    $productsArray[] =  $item->getQuantity() . "x " . $item->getName();
                }
            }
            $productsArray = implode(";<br>", $productsArray);

            $result[] = ["date_created" => $order->getDateCreated(), "total_price" => $order->getPrice(), "status" => $order->getStatusName(), "items" => $productsArray];
        }
        echo json_encode($result);
    }


    function date_sort($a, $b) {
        return (strtotime($b->getDateCreated()) - strtotime($a->getDateCreated()));
    }

    function checkDelivery() {
        if (!isset($_SESSION["delivery"]) && !isset($_SESSION["carry_out"])) {
            echo "Please, choose a delivery method before ordering!";
        }
    }
}
