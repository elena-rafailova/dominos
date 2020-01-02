<?php


namespace model;


use model\DAO\OthersDAO;

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

    static function getAll($category_id,$filter = null) {
        $othersDAO = new OthersDAO();

        return $othersDAO->getAll($category_id,$filter);
    }



}