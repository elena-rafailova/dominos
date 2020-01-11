<?php
include_once "header.php";
include_once "products_nav_view.php";
?>

<div class="container  mx-auto mt-5">

    <h1 id="name"></h1>
    <div id="pizza_info" class="container pb-2">
        <form action="index.php?target=cart&action=addToCart" method="post">
            <div id="pizza-background">
                <div class="container ">
                    <input type="hidden" id="id" name="pizza_id">
                    <div class="row">
                        <select name="dough" id="doughs" class="browser-default custom-select w-25 float-left mr-2 mt-2"  onchange="changePrice()">
                        </select>

                        <select name="size" id="sizes" class="browser-default custom-select w-25 float-left mt-2"   onchange="changePrice()">
                        </select><br>
                    </div>
                    <div class="row">
                        <input type="hidden" id="price_for_one" name="price_for_one" value="0">
                        <h4>Price: <span id="price"></span> BGN</h4>
                    </div>

                    <div class="row">
                        <img src="uploads/minus.png" class="" onclick="decrementValPizza()" class="icons float-left">
                        <div class="col-xs-10">
                            <input type="text" min="1" max="100" class="form-control w-25 float-left" name="quantity" id="quantity" value="1" required readonly>
                            <img src="uploads/plus.png" class="" onclick="incrementValPizza()" class="icons float-left">
                        </div>
                    </div>

                    <div class="row mt-1">
                        <h5 id="toppings"></h5>
                    </div>

                    <button type="button" onclick="hideOrShow()" class="btn btn-primary ">Customize</button><br>
                </div>
            </div>
            <div id="customize" class="container">
                <div class="row">
                    <div class="col-sm-3">
                        <h3>Sauces</h3>
                        <div id="sauces" class="pretty p-default"></div>
                    </div>
                    <div class="col-sm-3">
                        <h3>Cheeses</h3>
                        <div id="cheeses"></div>
                    </div>
                    <div class="col-sm-3">
                        <h3>Meats</h3>
                        <div id="meats"></div>
                    </div>
                    <div class="col-sm-3">
                        <h3>Vegetables</h3>
                        <div id="vegetables"></div>
                    </div>
                    <div class="col-sm-3">
                        <h3>Herbs</h3>
                        <div id="herbs"></div>
                    </div>
                    <div class="col-sm-3">
                        <h3>Miscellaneous</h3>
                        <div id="miscellaneous"></div>
                    </div>
                </div>
            </div>
            <input type="submit" name="add_to_cart" value="Add to cart" class="btn btn-primary mt-3">
        </form>
    </div>
</div>
<script>
    initializePizza();
</script>