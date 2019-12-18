<?php


namespace controller;


class PizzaController
{
    function show() {
        $pizzas = getPizzas();
        include_once "view/pizzas.php";
    }
}