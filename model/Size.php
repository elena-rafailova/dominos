<?php


namespace model;


use model\DAO\DoughDAO;
use model\DAO\SizeDAO;

class Size implements \JsonSerializable {
    private $id;
    private $name;
    private $price;
    private $slices;

    public function __construct($id, $name = null, $price = null, $slices = null) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->slices = $slices;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getSlices() {
        return $this->slices;
    }
    
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

}