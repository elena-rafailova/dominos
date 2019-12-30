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
</head>
<body>
    <h1>Our pizzas: </h1>
    <a href="index.php?target=pizza&action=showAll&category=1"><button>New</button></a>
    <a href="index.php?target=pizza&action=showAll&category=2"><button>Vegetarian</button></a>
    <a href="index.php?target=pizza&action=showAll&category=3"><button>Spicy</button></a>
    <table>
        <?php
        foreach ($pizzas as $pizza) {
            echo "<tr>";
            echo "<td><img src='" . $pizza->getImg_url() . "' /><br>";
            echo $pizza->getName() . "<br>";
            echo $pizza->printIngredients();
            echo "<form action='index.php?target=pizza&action=showPizza' method='post'>";
            echo "<input type='hidden' name='id' value='" . $pizza->getId() . "' >";
            echo "<input type='submit' value='Choose' name='choose'>";
            echo "</form><br></td></tr>";
        }
        ?>
    </table>
</body>
</html>