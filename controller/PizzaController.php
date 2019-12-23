<?php


namespace controller;

use model\Ingredient;
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

        $doughs = Pizza::getDoughsOrSizes(true);
        $sizes = Pizza::getDoughsOrSizes(false);


        foreach ($pizzas as $pizza) {
            $pizza->setPrice($pizza->getPrice() + $pizza->getDoughAndSizePrice());
        }
        include_once "view/pizzas.php";
    }

    function pizza() {
        if (isset($_POST["choose"])) {
            if (isset($_POST["id"])) {
                $pizza = Pizza::getPizzaById($_POST["id"]);

                $doughs = Pizza::getDoughsOrSizes(true);
                $sizes = Pizza::getDoughsOrSizes(false);

                $ingredients = [];
                for ($i = 0; $i < 6; $i++) {
                    $ingredients[] = Ingredient::getIngredientsByCategory($i+1);
                }
                include_once "view/pizza.php";
            }
        }
    }

}