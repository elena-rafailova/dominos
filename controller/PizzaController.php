<?php


namespace controller;

use model\Ingredient;
use model\Pizza;

class PizzaController
{
    function showAll() {
        include_once "view/pizzas.php";
    }

    function showPizza() {
        if (isset($_POST["choose"])) {
            if (isset($_POST["id"])) {
                $pizza = Pizza::getPizzaById($_POST["id"]);

                $doughs = Pizza::getDoughsOrSizes(true);
                $sizes = Pizza::getDoughsOrSizes(false);

                $ingredients = [];
                for ($i = 0; $i < 6; $i++) {
                    $ingredients[] = Ingredient::getIngredientsByCategory($i+1);
                }
                $ingredients[] = Ingredient::getIngredientsByCategory(null);
                include_once "view/pizza.php";
            }
        }
    }

    function getPizzasInfo() {
        if (!isset($_GET["category"])) {
            $pizzas = Pizza::getAllPizzas();
        } else {
            $category = $_GET["category"];
            $pizzas = Pizza::getAllPizzas($category);
        }
        echo json_encode($pizzas, JSON_UNESCAPED_UNICODE);
    }

}