<?php

include_once "main.php";

if (!isset($orders)) {
    header("index.php?target=user&action=showOrders");
}
?>
<body>
<h4>My orders</h4>
    <table>
        <th>Order Date</th>
        <th>Total Price</th>
        <th>Product ordered</th>
    <?php
    if($orders) {
        foreach ($orders as $order) {

            echo "<tr>";
            echo "<td> $order->date_created<br>";
            echo "<td> $order->total_price<br>";
            echo "<td> $order->product <br>";
            echo  "</td></tr>";
        }
    }
    else {
        echo "You have no orders.";
    }
    ?>
    </table>
</body>






