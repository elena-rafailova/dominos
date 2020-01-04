<?php


namespace model;


use model\DAO\AddressDAO;
use model\DAO\RestaurantDAO;
use function Sodium\add;

class Restaurant
{
    private $id;
    private $name;
    /** @var Address $address */
    private $address;

    public function __construct($id, $name, $address) {
        $this->id= $id;
        $this->name = $name;
        $this->address = $address;
    }

    public static function getAllRestaurants() {
        return RestaurantDAO::getAll();
    }
}