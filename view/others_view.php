<?php
include_once "header.php";
include_once "products_nav_view.php";
/*
 * others filter meanings:
 *
 * 1 - new
 * 2 - vegetarian
 * 3 - spicy
 * 0 - in none of the above
 * 4 - desserts
 * 5 - ice creams
 */

if(isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
}
 ?>

<div class="container  mx-auto mt-5  mb-3">
    <?php
    switch($category_id) {
        case 1:
            echo "<h1>Our starters: </h1>
            <button onclick='getOthers(1)' class='btn btn-primary'>All</button>
            <button onclick='getOthers(1,1)' class='btn btn-primary'>New</button>
            <button onclick='getOthers(1,2)' class='btn btn-primary'>Vegetarian</button>";
            break;
        case 2:
            echo "<h1>Our chicken: </h1>
            <button onclick='getOthers(2)' class='btn btn-primary'>All</button>
            <button onclick='getOthers(2,3)' class='btn btn-primary'>Spicy</button>";
            break;
        case 3:
            echo "<h1>Our pasta: </h1>
             <button onclick='getOthers(3)' class='btn btn-primary'>All</button>
             <button onclick='getOthers(3,1)' class='btn btn-primary'>New</button>
             <button onclick='getOthers(3,3)' class='btn btn-primary'>Spicy</button>";
            break;
        case 4:
            echo "<h1>Our salads: </h1>
            <button onclick='getOthers(4)' class='btn btn-primary'>All</button>
            <button onclick='getOthers(4,2)' class='btn btn-primary'>Vegetarian</button>";
            break;
        case 5:
            echo "<h1>Our sandwiches: </h1>";
            break;
        case 6:
            echo "<h1>Our dips: </h1>
             <button onclick='getOthers(6)' class='btn btn-primary'>All</button>
             <button onclick='getOthers(6,1)' class='btn btn-primary'>New</button>
             <button onclick='getOthers(6,3)' class='btn btn-primary'>Spicy</button>";
            break;
        case 7:
            echo "<h1>Our desserts: </h1>
            <button onclick='getOthers(7)' class='btn btn-primary'>All</button>
            <button onclick='getOthers(7,4)' class='btn btn-primary'>Desserts</button>
            <button onclick='getOthers(7,5)' class='btn btn-primary'>Ice Creams</button>";
            break;
        case 8:
            echo "<h1>Our drinks: </h1>";
            break;
    }?>
    <div id="others" class="container card-group  mt-2">
    </div>

    <script type="text/javascript">
        var category_id = <?= $category_id; ?>;
        getOthers(category_id);
    </script>
</div>

