<?php


namespace model;


class Others extends Product {
    private $description;
    private $others_category_id;


    public function __construct($id, $name, $img_url, $description, $filter, $category_id, $price , $quantity = null) {
        parent::__construct($id, $name, $this->img_url, $this->price, $quantity, $filter);

        $this->description = $description;
        $this->others_category_id = $category_id;
        $this->price = $price;
    }

}