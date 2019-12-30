<?php
include_once "main.php";

if (!isset($restaurants)) {
    header("index.php?target=restaurant&action=show");
}
?>

<body>
<table>
    <?php
    foreach ($restaurants as $restaurant) {
        echo "<tr>";
        echo "<td> $restaurant->name <br>";
        echo "$restaurant->street_name ";
        echo "$restaurant->street_number <br>";
        echo "$restaurant->phone_number <br>";
        echo "</tr></td>";
    }
    ?>
</table>
</body>


