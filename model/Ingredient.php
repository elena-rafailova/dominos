<?php


namespace model;


class Ingredient
{
    private $id;
    private $name;
    private $category;

    public function __construct($id, $name, $category) {
        $this->id = $id;
        $this->name = $name;
        $this->category = $category;
    }
}