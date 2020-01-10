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

<body>
<?php
switch($category_id) {
    case 1:
        echo "<h1>Our starters: </h1>
        <button onclick='getOthers(1,1)'>New</button>
        <button onclick='getOthers(1,2)'>Vegetarian</button>";
        break;
    case 2:
        echo "<h1>Our chicken: </h1>
        <button onclick='getOthers(2,3)'>Spicy</button>";
        break;
    case 3:
        echo "<h1>Our pasta: </h1>
         <button onclick='getOthers(3,1)'>New</button>
         <button onclick='getOthers(3,3)'>Spicy</button>";
        break;
    case 4:
        echo "<h1>Our salads: </h1>
        <button onclick='getOthers(4,2)'>Vegetarian</button>";
        break;
    case 5:
        echo "<h1>Our sandwiches: </h1>";
        break;
    case 6:
        echo "<h1>Our dips: </h1>
         <button onclick='getOthers(6,1)'>New</button>
         <button onclick='getOthers(6,3)'>Spicy</button>";
        break;
    case 7:
        echo "<h1>Our desserts: </h1>
        <button onclick='getOthers(7,4)'>Desserts</button>
        <button onclick='getOthers(7,5)'>Ice Creams</button>";
        break;
    case 8:
        echo "<h1>Our drinks: </h1>";
        break;
}?>
<table id="others">
</table>

<script type="text/javascript">

    var category_id = <?= $category_id; ?>;
    getOthers(category_id);

</script>
</body>

