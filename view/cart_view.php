<?php
include_once "header.php";
?>
<div id="deliveryPopUp">
    CHOOSE YOUR ORDER METHOD<br>
    <input type="button" value="Free Delivery" data-toggle="modal" class="btn btn-primary btn-info btn-lg" onclick="seeAddresses()" data-target="#delivery">
    <input type="button" value="Carry Out" data-toggle="modal" class="btn btn-primary btn-info btn-lg" onclick="seeRestaurants()" data-target="#carryOut">
</div>

<div id="delivery" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Select from your addresses:</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <select name="address" id="addresses" class="browser-default custom-select" >

                </select>
            </div>
            <div class="modal-footer">
                <input type="button" value="Order Now!" class="btn btn-primary " name="chooseOrdMethod" onclick="deliveryF()">
            </div>
        </div>
    </div>
</div>
<div id="carryOut" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Select restaurant:</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <select id="restaurants" class="browser-default custom-select">
                </select>
                <br><br><div id="map"></div>
            </div>
            <div class="modal-footer">
                <input type="button" value="Order Now!" data-dismiss="modal" class="btn btn-primary " name="chooseOrdMethod" onclick="carryOutF()">
            </div>
        </div>
    </div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA_O6dUhOX_YuXTAsIHtWVTJ-wcNjjhjlM&callback=getRestaurants"
        async defer></script>


<script>
    getAddresses();
    getRestaurants();
    var delivery = document.getElementById("delivery");
    var carryOut = document.getElementById("carryOut");
    var deliveryPopUp = document.getElementById("deliveryPopUp");
</script>

<div id="shopping_cart">


</div>
<script>viewCart();</script>