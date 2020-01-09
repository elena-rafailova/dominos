<?php


namespace model;


class Other extends Product {
    private $description;
    private $others_category_id;


    public function __construct($id, $name, $img_url, $description, $filter, $category_id, $price , $quantity = null) {
        parent::__construct($id, $name, $this->img_url, $this->price, $quantity, $filter);

        $this->img_url = $img_url;
        $this->description = $description;
        $this->others_category_id = $category_id;
        $this->price = $price;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getImgUrl()
    {
        return $this->img_url;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }
}