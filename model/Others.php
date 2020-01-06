<?php


namespace model;


class Others
{
    private $id;
    private $name;
    private $img_url;
    private $description;
    private $modified;
    private $filter;
    private $others_category_id;
    private $price;
    private $quantity;

    public function __construct($id, $name, $img_url, $description, $modified,$filter, $category_id, $price , $quantity = null) {
        $this->id = $id;
        $this->name = $name;
        $this->img_url = $img_url;
        $this->description = $description;
        $this->modified = $modified;
        $this->filter = $filter;
        $this->others_category_id = $category_id;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getId()
    {
        return $this->id;
    }


    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getPrice()
    {
        return $this->price;
    }

}