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
use model\Size;
use model\Dough;


class Pizza implements \JsonSerializable
{
    private $id;
    private $name;
    private $img_url;
    private $modified;
    private $price;
    private $ingredients;
    /** @var Dough $dough */
    private $dough;
    /** @var Size $size */
    private $size;
    private $category;
    private $quantity;

    public function __construct($id, $name, $img_url, $modified, $ingredients, $category = 0, $dough = null, $size = null, $quantity = null) {
        $this->id = $id;
        $this->name = $name;
        $this->img_url = $img_url;
        $this->modified = $modified;
        $this->ingredients = $ingredients;
        $this->category = $category;
        $this->dough = $dough;
        $this->size = $size;
        $this->quantity = $quantity;
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
        $ingredientsNames = [];
        /** @var Ingredient $ingredient */
        foreach ($this->ingredients as $ingredient) {
            $ingredientsNames[] = $ingredient->getName();
        }
        return $ingredientsNames;
    }

    function getId() {
        return $this->id;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }


    public function setPrice($price) {
        $this->price = $price;
    }


    static public function getPizzaById($id) {
        $pizzaDAO =  new PizzaDAO();
        return $pizzaDAO->getPizza($id);
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function setIngredients($ingredients) {
        $this->ingredients = $ingredients;
    }

    public function setDough($id) {
        $this->dough = new Dough($id);
    }

    public function setSize($id) {
        $this->size = new Size($id);
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }
}