<?php
include_once "header.php";
?>
<script src="view/js/pizzas-view.js"></script>

    <img id="img" class="product_img"/><br>
    <p id="name"></p>

    <form action="index.php?target=cart&action=addToCart" method="post">
        <input type="hidden" id="id" name="pizza_id">
        <select name="dough" id="doughs" onchange="changePrice()">
        </select>

        <select name="size" id="sizes"  onchange="changePrice()">
        </select><br>

        <input type="hidden" id="price_for_one" name="price_for_one" value="0">
        <div>Price: <span id="price"></span> BGN</div>

        <h6>Quantity</h6>

        <img src="uploads/minus.png" onclick="decrementVal()" class="icons">
        <input type="text" min="1" max="100" name="quantity" id="quantity" value="1" required readonly>
        <img src="uploads/plus.png" onclick="incrementVal()" class="icons">

        <h6>Toppings:</h6>
        <div id="toppings"></div>

        <input type="button" value="Customize" onclick="hideOrShow()"><br>
        <div id="customize">
            <h6>Sauces</h6>
            <div id="sauces">

            </div>

            <h6>Herbs</h6>
            <div id="herbs">

            </div>

            <h6>Cheeses</h6>
            <div id="cheeses"> <!--//on="priceChangeForIngr()">-->

            </div>

            <h6>Meats</h6>
            <div id="meats">

            </div>

            <h6>Vegetables</h6>
            <div id="vegetables">

            </div>

            <h6>Miscellaneous</h6>
            <div id="miscellaneous">

            </div>
        </div>
        <input type="submit" name="add_to_cart" value="Add">

    </form>
<script>
    initializePizza();
</script>