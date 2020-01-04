<?php


namespace controller;


use model\DAO\RestaurantDAO;
use model\Restaurant;

class RestaurantController
    {
    function show() {
        include_once "view/restaurants.php";
    }

    function getRestaurants() {
        $restaurants = Restaurant::getAllRestaurants();
        echo json_encode($restaurants, JSON_UNESCAPED_UNICODE);
    }
}