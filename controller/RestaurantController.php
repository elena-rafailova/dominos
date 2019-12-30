<?php


namespace controller;


use model\DAO\RestaurantDAO;

class RestaurantController
{
function show() {
        $restaurants = RestaurantDAO::getAll();
        include_once "view/restaurants.php";
}
}