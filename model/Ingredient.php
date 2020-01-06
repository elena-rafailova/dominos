<?php


namespace model;

use model\DAO\IngredientDAO;
use model\DAO\PizzaDAO;


class Ingredient implements \JsonSerializable
{
    private $id;
    private $name;
    private $category;
    private $price;

    public function __construct($id, $name = null, $category = null, $price = null) {
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

    public function getCategory()
    {
        return $this->category;
    }

    static public function getIngredientsByCategory($category) {
        return IngredientDAO::getByCategory($category);
    }

    static public function getIngredientById($id) {
        return IngredientDAO::getById($id);
    }

    public function findPrice() {
        $this->price = IngredientDAO::getPrice($this->id)["price"];
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }

}