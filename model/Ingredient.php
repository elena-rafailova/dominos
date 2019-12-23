<?php


namespace model;

use model\DAO\PizzaDAO;


class Ingredient
{
    private $id;
    private $name;
    private $category;
    private $price;

    public function __construct($id = null, $name = null, $category = null, $price = null) {
        $this->id = $id;
        $this->name = $name;
        $this->category = $category;
        $this->price = $price;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getName() {
        return $this->name;
    }

    public function getId() {
        return $this->id;
    }

    static public function getIngredientsByCategory($category) {
        $pizzaDAO =  new PizzaDAO();
        return $pizzaDAO->getIngredientsByCategory($category);
    }

    static public function getIngredientById($id) {
        $pizzaDAO = new PizzaDAO();
        return $pizzaDAO->getIngredientById($id);
    }

}