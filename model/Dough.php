<?php


namespace model;


class Dough
{
    private $id;
    private $name;
    private $price;

    public function __construct($id, $name, $price) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

}