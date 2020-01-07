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

define("MODIFIED", 1);
define("NOT_MODIFIED", 0);


class Pizza extends Product implements \JsonSerializable {
    private $modified;
    private $ingredients;

    /** @var Dough $dough */
    private $dough;

    /** @var Size $size */
    private $size;

    public function __construct($id, $name, $img_url, $modified, $ingredients, $filter = 0, $dough = null, $size = null, $quantity = null, $price = 0) {

        parent::__construct($id, $name, $img_url, $price, $quantity, $filter);
        $this->modified = $modified;
        $this->ingredients = $ingredients;
        $this->dough = $dough;
        $this->size = $size;
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

    public function setIngredients($ingredients) {
        $this->ingredients = $ingredients;
    }

    public function setDough($id) {
        $this->dough = new Dough($id);
    }

    public function setSize($id) {
        $this->size = new Size($id);
    }


    public function jsonSerialize() {
        return get_object_vars($this);
    }


    public function getModified() {
        return $this->modified;
    }

    public function setModified($modified) {
        if ($modified) {
            $this->modified = MODIFIED;
        } else {
            $this->modified = NOT_MODIFIED;
        }
    }
}