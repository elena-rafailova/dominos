<?php

namespace controller;

use exceptions\BadRequestException;
use exceptions\NotFoundException;
use model\Cart;
use model\DAO\IngredientDAO;
use model\DAO\OrderDAO;
use model\DAO\PizzaDAO;
use model\Ingredient;
use model\Order;
use model\Other;
use model\Pizza;


define("MIN_QUANTITY", 1);
define("MAX_QUANTITY", 100);
define("STATUS_PENDING", 1);
define("ROWS_PER_PAGE", 5);
define("MAX_COMMENT_LENGTH", 254);


class OrderController {

    public function finish() {
        if (isset($_POST["order"])) {
            /** @var Cart $cart */
            $cart = $_SESSION["cart"];
            $user = json_decode($_SESSION['logged_user']);



            if ($cart->isCartEmpty()) {
                throw new BadRequestException("Your cart is empty!");
            }

            foreach ($cart->getProducts() as $product) {
                if ($product->getQuantity() > MAX_QUANTITY || $product->getQuantity() < MIN_QUANTITY) {
                    throw new BadRequestException("Invalid quantity!");
                }
                if ($product instanceof Pizza && $product->getModified()) {
                    $ingredients = $product->getIngredients();
                    /** @var Ingredient $ingredient */
                    $ingredientDAO = new IngredientDAO();
                    foreach ($ingredients as $ingredient) {
                        if (!$ingredientDAO->getById($ingredient->getId())) {
                            throw new NotFoundException("Ingredient not found!");
                        }
                    }

                    $pizzaDAO = new PizzaDAO();
                    $newPizzaId = $pizzaDAO->addNew($product->getName(), $product->getIngredients());

                    if (isset($newPizzaId) && $newPizzaId !== false) {
                        $product->setId($newPizzaId);
                    } else {
                        throw new BadRequestException("Sorry we could not process your request!");
                    }
                }
            }

            $comment = "";
            if(isset($_POST["comment"])) {
                $comment = $_POST["comment"];
            }
            if (mb_strlen($comment) > MAX_COMMENT_LENGTH) {
                $comment = mb_substr($comment, 0, MAX_COMMENT_LENGTH);
            }

            $payment = 1;
            if (isset($_POST["payment_type"])) {
                $payment = intval($_POST["payment_type"]);
            }

            $delivery_addr = $_SESSION["delivery"] ?? null;
            $restaurant_id = $_SESSION["carry_out"] ?? null;

            if ($restaurant_id || $delivery_addr) {
                $order = new Order(null, $user->id, null, STATUS_PENDING,
                    $delivery_addr, $restaurant_id, $payment, $cart->getPrice(),
                    $cart->getProducts(), $comment);

                $orderDAO = new OrderDAO();
                try {
                    $orderDAO->placeOrder($order);
                } catch (\PDOException $e) {
                    throw new BadRequestException("Sorry we could not process your request!");
                }
                $_SESSION["cart"] = new Cart();
                header("Location: index.php?target=cart&action=seeCart&finish");
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
        $page = 1;
        if (isset($_GET["page"])) {
            $page = $_GET["page"];
        }
        $user_id = json_decode($_SESSION['logged_user'])->id;
        $orderDAO = new OrderDAO();
        $orders = $orderDAO->getOrders($user_id);

        if ($orders === false) {
            echo json_encode(["orders" => "empty"]);
            die();
        }
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
        $maxPage = ceil(count($orderArray) / ROWS_PER_PAGE);
        if ($page > $maxPage) $page = $maxPage;
        if ($page < 1) $page = 1;
        $orderArray = array_slice($orderArray, ($page-1) * ROWS_PER_PAGE, ROWS_PER_PAGE);
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

            $result["orders"][] = ["date_created" => $order->getDateCreated(),
                        "total_price" => $order->getPrice(),
                        "status" => $order->getStatusName(),
                        "items" => $productsArray];
        }
        $result["max_pages"] = $maxPage;
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
