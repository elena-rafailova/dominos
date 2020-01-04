<?php
include_once "main.php";
include_once "menu-list.php";

?>

<body> <!--onload="getTimes()"-->
    <br>
    <?php if (!isset($_SESSION["delivery"]) && !isset($_SESSION["carry_out"])) {?>
    <div id="deliveryPopUp">
        CHOOSE YOUR ORDER METHOD<br>
        <input type="button" value="Free Delivery" onclick="seeAddresses()">
        <input type="button" value="Carry Out" onclick="seeRestaurants()">
    </div>

    <div id="delivery">
        <select name="address" id="addresses">

        </select>
        <input type="button" value="Order Now!" name="chooseOrdMethod" onclick="deliveryF()">
    </div>
    <div id="carryOut">
        <select id="restaurants">
        </select>
        <br><br><div id="map"></div>
        <input type="button" value="Order Now!" name="chooseOrdMethod" onclick="carryOutF()">

    </div>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA_O6dUhOX_YuXTAsIHtWVTJ-wcNjjhjlM&callback=getRestaurants"
                async defer></script>
    <?php } ?>

    <h1>Our pizzas: </h1>
    <button onclick="getPizzas(1)">New</button></a>
    <button onclick="getPizzas(2)">Vegetarian</button></a>
    <button onclick="getPizzas(3)">Spicy</button></a>
    <table id="pizzas">
    </table>


    <script>
        getPizzas();
        getAddresses();
        getRestaurants();
        var delivery = document.getElementById("delivery");
        delivery.style.display = "none";
        var carryOut = document.getElementById("carryOut");
        carryOut.style.display = "none";
        var deliveryPopUp = document.getElementById("deliveryPopUp");
    </script>
</body>
