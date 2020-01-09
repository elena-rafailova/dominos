<?php

namespace model\DAO;

use model\Others;
use model\Pizza;
use model\Order;
use PDO;
use PDOException;

class OrderDAO extends BaseDAO {

    /** @var Order $order */
    public function placeOrder($order) {
        $pdo = parent::getPDO();
        try {
            $pdo->beginTransaction();
            $values = [];
            $values[] = $order->getUserId();
            $values[] = $order->getComment();
            $values[] = $order->getDeliveryAddress();
            $values[] = $order->getRestaurant();
            $values[] = $order->getPaymentType();
            $values[] = $order->getPrice();

            $sql = "INSERT INTO orders(user_id, comment, delivery_address_id, restaurant_id, payment_type_id, total_price)
                    VALUES(?, ?, ?, ?, ?, ?)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute($values);

            $orderId = $pdo->lastInsertId();

            foreach ($order->getItems() as $item) {
                /** @var Pizza $item */
                if($item instanceof Pizza) {
                    $itemValues = [];
                    $itemValues[] = $orderId;
                    $itemValues[] = $item->getId();
                    $itemValues[] = $item->getQuantity();
                    $itemValues[] = $item->getSize()->getId();
                    $itemValues[] = $item->getDough()->getId();

                    $sql1 = "INSERT INTO orders_have_pizzas(order_id, pizza_id, quantity, size_id, dough_id) VALUES (?, ?, ?, ?, ?)";
                    $stmt1 = $pdo->prepare($sql1);
                    $stmt1->execute($itemValues);
                } else if ($item instanceof Others) {
                    $itemValues = [];
                    $itemValues[] = $orderId;
                    $itemValues[] = $item->getId();
                    $itemValues[] = $item->getQuantity();
                    $sql1 = "INSERT INTO orders_have_others(order_id, other_id, quantity) VALUES (?, ?, ?)";
                    $stmt1 = $pdo->prepare($sql1);
                    $stmt1->execute($itemValues);
                }
            }

            $pdo->commit();
        }catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }
    }
}