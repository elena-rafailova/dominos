<?php


namespace controller;

use model\Pizza;

class PizzaController
{
    function show() {
        if (!isset($_GET["category"])) {
            $pizzas = Pizza::getAllPizzas();
        } else {
            $category = $_GET["category"];
            $pizzas = Pizza::getAllPizzas($category);
        }

        foreach ($pizzas as $pizza) {
            $pizza->setPrice($pizza->getPrice() + $pizza->getDoughAndSizePrice());
        }
        include_once "view/pizzas.php";
    }

}