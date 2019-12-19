<?php
include_once "main.php";

if (!isset($pizzas)) {
    header("index.php?target=pizza&action=show");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <h1>Our pizzas: </h1>
    <a href="index.php?target=pizza&action=show&category=1"><button>New</button></a>
    <a href="index.php?target=pizza&action=show&category=2"><button>Vegetarian</button></a>
    <a href="index.php?target=pizza&action=show&category=3"><button>Spicy</button></a>
    <table>
        <tr>
            <th>Pizza Name:</th>
            <th>Ingredients:</th>
            <th>Price:</th>
            <th>Picture:</th>
            <th>Dough:</th>
            <th>Size:</th>
            <th>Category:</th>
        </tr>
        <?php
        foreach ($pizzas as $pizza) {
            echo "<tr>";
            echo "<td>" . $pizza->getName() . "</td>";
            echo "<td>" . $pizza->printIngredients() . "</td>";
            echo "<td>" . $pizza->getPrice() . "</td>";
            echo "<td><img src='" . $pizza->getImg_url() . "' /></td>";

            echo "<td>";
            echo "<select>";
            foreach ($doughs as $dough) {
                echo "<option value='" . $dough["id"] . "'>";
                echo $dough["name"] . ((isset($dough["price"]) && $dough["price"] != 0) ? " (+" . $dough["price"] . "lb)" : "");
                echo "</option>";
            }
            echo "</select>";
            echo "</td>";
            echo "<td>";
            echo "<select>";
            foreach ($sizes as $size) {
                echo "<option value='" . $size["id"] . "' " . (($pizza->getSize() == $size["id"]) ? "selected" : "") . ">";
                    echo $size["name"] . ((isset($size["slices"])) ? " (" . $size["slices"] . " Slices)" : "");
                echo "</option>";
            }
            echo "</select>";
            echo "</td>";
            echo "<td>" . $pizza->getCategory() . "</td>";

            echo "</tr>";
        }

        ?>
    </table>
</body>
</html>