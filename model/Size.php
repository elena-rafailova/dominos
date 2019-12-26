<?php


namespace model;


class Size {
    private $id;
    private $name;
    private $price;
    private $slices;

    public function __construct($id, $name, $price, $slices) {
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
}