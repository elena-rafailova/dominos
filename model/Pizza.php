<?php


namespace model;


class Pizza
{
    private $id;
    private $name;
    private $img_url;
    private $modified;
    private $ingredients = [];
    private $dough;
    private $size;
    private $category;

    public function __construct($id, $name, $img_url, $modified, $ingredients, $category, $dough = null, $size = null) {
        $this->id = $id;
        $this->name = $name;
        $this->img_url = $img_url;
        $this->modified = $modified;
        $this->ingredients = $ingredients;
        $this->category = $category;
        $this->dough = $dough;
        $this->size = $size;
    }

}