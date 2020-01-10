<?php
include_once "header.php";
?>
<?php if (!isset($_SESSION["delivery"]) && !isset($_SESSION["carry_out"])) {?>
<div id="deliveryPopUp">
    CHOOSE YOUR ORDER METHOD<br>
    <input type="button" value="Free Delivery" class="btn btn-primary " onclick="seeAddresses()">
    <input type="button" value="Carry Out" class="btn btn-primary " onclick="seeRestaurants()">
</div>

<div id="delivery">
    <select name="address" id="addresses" class="mdb-select md-form">

    </select>
    <input type="button" value="Order Now!" class="btn btn-primary " name="chooseOrdMethod" onclick="deliveryF()">
</div>
<div id="carryOut">
    <select id="restaurants">
    </select>
    <br><br><div id="map"></div>
    <input type="button" value="Order Now!"  class="btn btn-primary " name="chooseOrdMethod" onclick="carryOutF()">

</div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA_O6dUhOX_YuXTAsIHtWVTJ-wcNjjhjlM&callback=getRestaurants"
        async defer></script>
<?php } ?>
<script>
    getAddresses();
    getRestaurants();
    var delivery = document.getElementById("delivery");
    delivery.style.display = "none";
    var carryOut = document.getElementById("carryOut");
    carryOut.style.display = "none";
    var deliveryPopUp = document.getElementById("deliveryPopUp");
</script>

<div id="shopping_cart">


</div>
<script>viewCart();</script>