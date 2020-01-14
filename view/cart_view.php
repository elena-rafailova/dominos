<?php
include_once "header.php";
?>

<div class="container mx-auto w-70 mt-2 mb-3">
    <div class="container mx-auto">
        <div id="deliveryPopUp">
            CHOOSE YOUR ORDER METHOD<br>
            <input type="button" value="Free Delivery" data-toggle="modal" class="btn btn-primary btn-info btn-lg" data-target="#delivery">
            <input type="button" value="Carry Out" data-toggle="modal" class="btn btn-primary btn-info btn-lg" data-target="#carryOut">
        </div>

        <div id="delivery" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Select from your addresses</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <select name="address" id="addresses" class="browser-default custom-select w-100" >

                        </select>
                    </div>
                    <div class="modal-footer">
                        <input type="button" value="Order Now!" data-dismiss="modal" class="btn btn-primary " name="chooseOrdMethod" onclick="deliveryF()">
                    </div>
                </div>
            </div>
        </div>
        <div id="carryOut" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Select restaurant</h4>
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
        <p id="alert_if_delivery_empty"></p>

        <p class="alert alert-success alert-dismissible fade show mt-3" id="finished_order">
            <button type="button" class="close" data-dismiss="alert">×</button>
            Your order is completed!
        </p>


        <p class="alert alert-warning alert-dismissible fade show mt-3" id="empty_cart_warning">
            <button type="button" class="close" data-dismiss="alert">×</button>
            Your shopping cart is empty!
        </p>

        <p class="alert alert-warning alert-dismissible fade show mt-3" id="quantity_warning">
            <button type="button" class="close" data-dismiss="alert">×</button>
            Maximal quantity is 100!
        </p>

        <script>
            document.getElementById("finished_order").style.display="none";

            getAddresses();
            //getRestaurants();
            deliveryAlert();
        </script>

        <div id="shopping_cart" class="container mt-5">
        </div>

    </div>
</div>
<script>
    document.getElementById("empty_cart_warning").style.display="none";
    document.getElementById("quantity_warning").style.display="none";
    viewCart();
    finishedOrder();
</script>