<?php
include_once "header.php";
include_once "products_nav_view.php";

?>
<div class="container mx-auto mt-5  mb-3 ">
    <h1>Our pizzas: </h1>

    <button onclick="getPizzas(0)"  class="btn btn-primary ">All</button></a>
    <button onclick="getPizzas(1)"  class="btn btn-primary ">New</button></a>
    <button onclick="getPizzas(2)" class="btn btn-primary ">Vegetarian</button></a>
    <button onclick="getPizzas(3)" class="btn btn-primary ">Spicy</button></a>
    <div id="pizzas" class="card-group mt-2">
    </div>

    <script>
        getPizzas();
        // getAddresses();
        // getRestaurants();
        // var delivery = document.getElementById("delivery");
        // delivery.style.display = "none";
        // var carryOut = document.getElementById("carryOut");
        // carryOut.style.display = "none";
        // var deliveryPopUp = document.getElementById("deliveryPopUp");
    </script>
</div>