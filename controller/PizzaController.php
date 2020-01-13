<?php


namespace controller;

use exceptions\NotFoundException;
use model\DAO\DoughDAO;
use model\DAO\IngredientDAO;
use model\DAO\PizzaDAO;
use model\DAO\SizeDAO;
use model\Ingredient;

class PizzaController
{
    public function showAll() {
        include_once "view/pizzas_view.php";
    }

    public function show() {
        if (isset($_GET["id"])) {
            $pizzaDAO = new PizzaDAO();
            $pizza = $pizzaDAO->getPizza($_GET["id"]);
            if ($pizza === false) {
                throw new NotFoundException("You are trying to reach non-existing pizza!");
            }
            include_once "view/pizza_view.php";
        }
    }

    public function getDoughs() {
        $doughDAO = new DoughDAO();
        echo json_encode($doughDAO->getAll(), JSON_UNESCAPED_UNICODE);
    }

    public function getSizes() {
        $sizeDAO = new SizeDAO();
        echo json_encode($sizeDAO->getAll(), JSON_UNESCAPED_UNICODE);
    }

    public function getPizza() {
        if (isset($_GET["id"])) {
            $pizzaDAO = new PizzaDAO();
            $pizza = $pizzaDAO->getPizza($_GET["id"]);


            $price = 0;
            /** @var Ingredient $ingredient */
            foreach ($pizza->getIngredients() as $ingredient) {
                $price += $ingredient->getPrice();
            }
            $doughDAO = new DoughDAO();
            $price += $doughDAO->getPrice($pizza->getDough()->getId());
            $sizeDAO = new SizeDAO();
            $price += $sizeDAO->getPrice($pizza->getSize()->getId());

            $pizza->setPrice($price);

            echo json_encode($pizza, JSON_UNESCAPED_UNICODE);
        }
    }

    public function getIngr()
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

    public function getPizzasInfo() {
        $pizzaDAO = new PizzaDAO();
        if (!isset($_GET["filter"])) {
            $pizzas = $pizzaDAO->getAll();
        } else {
            $filter = $_GET["filter"];
            $pizzas = $pizzaDAO->getAll($filter);
        }
        echo json_encode($pizzas, JSON_UNESCAPED_UNICODE);
    }

    public function getDoughPrice() {
        if (isset($_GET["id"])) {
            $doughDAO = new DoughDAO();
            echo $doughDAO->getPrice($_GET["id"]);
        }
    }

    public function getSizePrice() {
        if (isset($_GET["id"])) {
            $sizeDAO = new SizeDAO();

            echo $sizeDAO->getPrice($_GET["id"]);
        }
    }

    public function getIngrPrice() {
        if (isset($_GET["id"])) {
            $ingredientDAO = new IngredientDAO();
            echo $ingredientDAO->getPrice($_GET["id"]);
        }
    }

}