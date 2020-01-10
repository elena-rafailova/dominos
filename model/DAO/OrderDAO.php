<?php

namespace model\DAO;

use model\Dough;
use model\Other;
use model\Pizza;
use model\Order;
use model\Size;
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
                } else if ($item instanceof Other) {
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

    function getOrders($user_id) {
        $pdo = parent::getPDO();
        $sql ="SELECT ord.id, ord.date_created, ord.total_price,st.name AS status_name, p.name AS product, s.name AS size ,d.name AS dough, ohp.quantity
                FROM orders AS ord JOIN orders_have_pizzas AS ohp
                ON (ord.id = ohp.order_id) JOIN pizzas as p ON (ohp.pizza_id = p.id)
                JOIN sizes AS s ON (s.id=ohp.size_id)
                JOIN doughs AS d ON (d.id=ohp.dough_id)
                JOIN statuses AS st ON (ord.status_id = st.id)
                WHERE ord.user_id = ?;";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $orders=[];
        foreach ($rows as $row) {
            $pizza = new Pizza(null, $row["product"],null,null,null,
                null,new Dough(null, $row['dough']), new Size(null,$row['size']), $row["quantity"]);
            $orders[]=new Order($row["id"], $user_id, $row["date_created"], $row["status_name"],
                null,null,null, $row["total_price"], [$pizza], null );
        }
        $sql2 ="SELECT ord.id, ord.date_created, ord.total_price,st.name AS status_name, oth.name AS product,oho.quantity
                FROM orders AS ord JOIN orders_have_others AS oho
                ON (ord.id = oho.order_id) JOIN others as oth ON (oho.other_id = oth.id)
                JOIN statuses AS st ON (ord.status_id = st.id)
                WHERE ord.user_id = ?;";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute([$user_id]);
        $rows = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            $other = new Other(null,$row["product"],null,null,null,null,null,$row["quantity"]);
            $orders[]=new Order($row["id"], $user_id, $row["date_created"], $row["status_name"],
                null,null,null, $row["total_price"], [$other], null );
        }
        if (empty($rows)) {
            return false;
        } else {
            return $orders;
        }
    }
}
//  UNION
//                SELECT ord.id,ord.date_created, ord.total_price,ord.status_id, IF(oho.order_id= ord.id, o.name, NULL) AS product
//                FROM orders AS ord JOIN orders_have_others AS oho
//                ON (ord.id = oho.order_id) JOIN others as o ON (oho.other_id = o.id) WHERE ord.user_id  = ?;