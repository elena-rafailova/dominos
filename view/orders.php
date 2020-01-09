<?php

include_once "main.php";

if (!isset($orders)) {
    header("index.php?target=order&action=showOrders");
}
//print_r($orders);
?>
<body>
<h4>My orders</h4>
    <table>
        <th>Order Date</th>
        <th>Total Price</th>
        <th>Product ordered</th>
        <th>ID of order</th>
    <?php
    if($orders) {
//        foreach ($orders as $order) {
//            $array = array($order);
//            foreach ($order as $value) {
//               // $array = array($value);
//
//           }
//            print_r($array);
//
//           }
//            echo "<td> $order->date_created<br>";
//            echo "<td> $order->total_price<br>";
//            echo "<td> $order->product <br>";
//            echo "<td> $order->id <br>";
//            echo  "</td></tr>";

    }
    else {
        echo "You have no orders.";
    }

    ?>
    </table>
</body>






