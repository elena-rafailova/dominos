<?php


namespace controller;

use model\DAO\DoughDAO;
use model\DAO\IngredientDAO;
use model\DAO\PizzaDAO;
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
            include_once "view/pizza.php";
        }
    }

    function getDoughs() {
        $doughDAO = new DoughDAO();
        echo json_encode($doughDAO->getAll(), JSON_UNESCAPED_UNICODE);
    }

    function getSizes() {
        $sizeDAO = new SizeDAO();
        echo json_encode($sizeDAO->getAll(), JSON_UNESCAPED_UNICODE);
    }

    function getPizza() {
        if (isset($_GET["id"])) {
            $pizzaDAO = new PizzaDAO();
            $pizza = $pizzaDAO->getPizza($_GET["id"]);
            echo json_encode($pizza, JSON_UNESCAPED_UNICODE);
        }
    }

    function getIngr()
    {
        if (isset($_GET["category"])) {
            if (isset($_GET["pizza"])) {
                $pizzaDAO = new PizzaDAO();
                $pizza = $pizzaDAO->getPizza($_GET["pizza"]);
            }

            $ingredientDAO = new IngredientDAO();
            $ingredients = $ingredientDAO->getAll();

            $result = [];
            $result["ingredients"] = [];
            /** @var Ingredient $ingredient */
            foreach ($ingredients as $ingredient) {
                if ($ingredient->getCategory() == $_GET["category"]) {
                    $result["ingredients"][] = $ingredient;
                }
            }
            $result["pizzaIngredients"] = $pizza->getIngrNames();
            echo json_encode($result, JSON_UNESCAPED_UNICODE);

        }
    }

    function getPizzasInfo() {
        $pizzaDAO = new PizzaDAO();
        if (!isset($_GET["category"])) {
            $pizzas = $pizzaDAO->getAll();
        } else {
            $category = $_GET["category"];
            $pizzas = $pizzaDAO->getAll($category);
        }
        echo json_encode($pizzas, JSON_UNESCAPED_UNICODE);
    }

    function getDoughPrice() {
        if (isset($_GET["id"])) {
            $doughDAO = new DoughDAO();
            echo $doughDAO->getPrice($_GET["id"]);
        }
    }

    function getSizePrice() {
        if (isset($_GET["id"])) {
            $sizeDAO = new SizeDAO();

            echo $sizeDAO->getPrice($_GET["id"]);
        }
    }

    function getIngrPrice() {
        if (isset($_GET["id"])) {
            $ingredientDAO = new IngredientDAO();
            echo $ingredientDAO->getPrice($_GET["id"]);
        }
    }

}