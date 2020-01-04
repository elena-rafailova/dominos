<?php


namespace controller;

use model\DAO\SizeDAO;
use model\Dough;
use model\Ingredient;
use model\Pizza;
use model\Size;

class PizzaController
{
    function showAll() {
        include_once "view/pizzas.php";
    }

    function show() {
        if (isset($_GET["id"])) {
//            $pizza = Pizza::getPizzaById($_GET["id"]);
//            $doughs = Pizza::getDoughsOrSizes(true);
//            $sizes = Pizza::getDoughsOrSizes(false);
//
//            $ingredients = [];
//            for ($i = 0; $i < 6; $i++) {
//                $ingredients[] = Ingredient::getIngredientsByCategory($i+1);
//            }
//            //$ingredients[] = Ingredient::getIngredientsByCategory(null);
            include_once "view/pizza.php";
        }
    }

    function getDoughs() {
        echo json_encode(Dough::getAll(), JSON_UNESCAPED_UNICODE);
    }

    function getSizes() {
        echo json_encode(Size::getAll(), JSON_UNESCAPED_UNICODE);
    }

    function getPizza() {
        if (isset($_GET["id"])) {
            $pizza = Pizza::getPizzaById($_GET["id"]);
            echo json_encode($pizza, JSON_UNESCAPED_UNICODE);
        }
    }

    function getIngr() {
        if (isset($_GET["category"])) {
            echo json_encode(Ingredient::getIngredientsByCategory($_GET["category"]), JSON_UNESCAPED_UNICODE);
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

    function getDoughPrice() {
        if (isset($_GET["id"])) {
            $dough = new Dough($_GET["id"], null, null);
            $dough->findPrice();
            echo $dough->getPrice();
        }
    }

    function getSizePrice() {
        if (isset($_GET["id"])) {
            $dough = new Size($_GET["id"], null, null, null);
            $dough->findPrice();
            echo $dough->getPrice();
        }
    }

    function getIngrPrice() {
        if (isset($_GET["id"])) {
            $ingredient = new Ingredient($_GET["id"], null, null, null);
            $ingredient->findPrice();
            echo $ingredient->getPrice();
        }
    }

}