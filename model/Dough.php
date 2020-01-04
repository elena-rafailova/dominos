<?php


namespace model;


use model\DAO\DoughDAO;

class Dough implements \JsonSerializable
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

    public function findPrice() {
        $this->price = DoughDAO::getPrice($this->id)["price"];
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public static function getAll() {
        return DoughDAO::getAll();
    }
}