<?php


namespace model;


class Product implements \JsonSerializable {
    protected $id;
    protected $name;
    protected $img_url;
    protected $price;
    protected $quantity;
    protected $filter;

    public function __construct($id, $name, $img_url, $price, $quantity, $filter) {
        $this->id = $id;
        $this->name = $name;
        $this->img_url = $img_url;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->filter = $filter;
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

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function addOneToQuantity() {
        $this->quantity++;
    }

    public function subtractOneFromQuantity() {
        $this->quantity--;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }
}