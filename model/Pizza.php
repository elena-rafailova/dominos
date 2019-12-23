<?php

/*
 * pizza category meanings:
 *
 * 1 - new pizza
 * 2 - vegetarian
 * 3 - spicy
 * 0 - in none of the above
 *
 */
namespace model;

include_once "Ingredient.php";

use model\Ingredient;
use model\DAO\PizzaDAO;


class Pizza
{
    private $id;
    private $name;
    private $img_url;
    private $modified;
    private $price;
    private $ingredients;
    private $dough;
    private $size;
    private $category;

    public function __construct($id, $name, $img_url, $modified, $ingredients, $price, $category = 0, $dough = null, $size = null) {
        $this->id = $id;
        $this->name = $name;
        $this->img_url = $img_url;
        $this->modified = $modified;
        $this->ingredients = $ingredients;
        $this->price = $price;
        $this->category = $category;
        $this->dough = $dough;
        $this->size = $size;
    }

    static function getAllPizzas($category = null) {
        $pizzaDAO = new PizzaDAO();

        return $pizzaDAO->getAll($category);
    }

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getCategory() {
        return $this->category;
    }

    public function getImg_url() {
        return $this->img_url;
    }

    public function getDough()
    {
        return $this->dough;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function getIngredients() {
        return $this->ingredients;
    }

    public function getIngrNames() {
        $ingredientsName = [];
        foreach ($this->ingredients as $ingredient) {
            $ingredientsName[] = $ingredient->getName();
        }
        return $ingredientsName;
    }

    function getId() {
        return $this->id;
    }

    public function printIngredients() {
        $ingredients = $this->getIngredients();
        $ingrs = [];
        foreach ($ingredients as $ingredient) {
            $ingrs[] = $ingredient->getName();
        }
        return implode(", ", $ingrs);
    }


    public function setPrice($price) {
        $this->price = $price;
    }

    public function getDoughAndSizePrice() {
        $pizzaDAO = new PizzaDAO();
        $DAndSPrice = $pizzaDAO->getPriceFromDoughAndSize($this->dough, $this->size);
        return $DAndSPrice;
    }

    static public function getDoughsOrSizes($doughs = true) {
        $pizzaDAO = new PizzaDAO();
        $result = $pizzaDAO->getDoughsOrSizes($doughs);
        return $result;
    }

    static public function getPizzaById($id) {
        $pizzaDAO =  new PizzaDAO();
        return $pizzaDAO->getPizza($id);
    }
}