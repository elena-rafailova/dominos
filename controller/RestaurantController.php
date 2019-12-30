<?php


namespace controller;


use model\DAO\RestaurantDAO;

class RestaurantController
    {
    function show() {
        include_once "view/restaurants.php";
    }

    function getRestaurants() {
        $restaurants = RestaurantDAO::getAll();
        echo json_encode($restaurants, JSON_UNESCAPED_UNICODE);
    }
}