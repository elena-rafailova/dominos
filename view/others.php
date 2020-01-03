<?php
include_once "main.php";
include_once "menu-list.php";

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
    $category_id=$_GET['category_id'];
//    if (!isset($others)) {
//        header("index.php?target=others&action=showOthers&category_id =". $category_id);
//    }
}

?>

<body>
<?php switch($category_id) {
    case 1:
        echo "<h1>Our starters: </h1>
        <button onclick='getOthers(1, 1);'>New</button>
        <button onclick='getOthers(1, 2);'>Vegetarian</button>";
        break;
    case 2:
        echo "<h1>Our chicken: </h1>
        <button onclick='getOthers(2,3);'>Spicy</button>";
        break;
    case 3:
        echo "<h1>Our pasta: </h1>
        <button onclick='getOthers(3, 1);'>New</button>
        <button onclick='getOthers(3,3);'>Spicy</button>";
        break;
    case 4:
        echo "<h1>Our salads: </h1>
        <button onclick='getOthers(4, 2);'>Vegetarian</button>";
        break;
    case 5:
        echo "<h1>Our sandwiches: </h1>";
        break;
    case 6:
        echo "<h1>Our dips: </h1>
        <button onclick='getOthers(6, 1);'>New</button>
        <button onclick='getOthers(6, 3);'>Spicy</button>";
        break;
    case 7:
        echo "<h1>Our desserts: </h1>
        <button onclick='getOthers(7, 4);'>Desserts</button>
        <button onclick='getOthers(7, 5);'>Ice Creams</button>";
        break;
    case 8:
        echo "<h1>Our drinks: </h1>";
        break;
} ?>
<table id="others">
<?php
//    foreach ($others as $other) {
//        echo "<tr>";
//        echo "<td><img src='" . $other->img_url. "' /><br>";
//        echo $other->name . "<br>";
//        echo "<hr>";
//        echo $other->description . "<br>";
//        if($category_id == 8) {
//            switch ($other->name) {
//                case 'COCA-COLA':
//                    echo "Size: <select id='coca-cola' onchange='updatePrice(this.id);'>
//                  <option  selected disabled hidden>Choose here</option>
//                  <option value='2'>0.5 L </option>
//                  <option value='3.1'>1.5 L </option></select>";
//
//                    echo '<div id="coca-cola-price"><p>Price: </p></div> ';
//                    break;
//                case 'COCA-COLA ZERO':
//                    echo "Size: <select id='coca-cola-zero' onchange='updatePrice(this.id);'>
//                  <option  selected disabled hidden>Choose here</option>
//                  <option value='2'>0.5 L </option>
//                  <option value='3.1'>1.5 L </option></select>";
//
//                    echo '<div id="coca-cola-zero-price"><p>Price: </p></div> ';
//                    break;
//                case 'FANTA':
//                    echo "Size: <select id='fanta' onchange='updatePrice(this.id);'>
//                  <option  selected disabled hidden>Choose here</option>
//                  <option value='2'>0.5 L </option>
//                  <option value='3.1'>1.5 L </option></select>";
//
//                    echo '<div id="fanta-price"><p>Price: </p></div> ';
//                    break;
//                case 'SPRITE':
//                    echo "Size: <select id='sprite' onchange='updatePrice(this.id);'>
//                  <option  selected disabled hidden>Choose here</option>
//                  <option value='2'>0.5 L </option>
//                  <option value='3.1'>1.5 L </option></select>";
//
//                    echo '<div id="sprite-price"><p>Price: </p></div> ';
//                    break;
//                case 'MINERAL WATER':
//                    echo "Size: <select id='mineral-water' onchange='updatePrice(this.id);'>
//                  <option  selected disabled hidden>Choose here</option>
//                  <option value='1'>0.5 L </option>
//                  <option value='1.5'>1.5 L </option></select>";
//
//                    echo '<div id="mineral-water-price"><p>Price: </p></div> ';
//                    break;
//                case 'ZAGORKA':
//                    echo "Size: <select id='zagorka' onchange='updatePrice(this.id);'>
//                  <option value='' selected disabled hidden>Choose here</option>
//                  <option value='1.7'>0.33 L </option>
//                  <option value='2.6'>1 L </option></select>";
//
//                    echo '<div id="zagorka-price"><p>Price: </p></div> ';
//                    break;
//                case 'MALEE':
//                    echo "Size: <select id='malee' onchange='updatePrice(this.id);'>
//                  <option  selected disabled hidden>Choose here</option>
//                  <option value='2.4'>COCONUT WATER 0.33 L </option>
//                  <option value='2.4'>FRUIT JUICES MANGO 0.33 L </option>
//                  <option value='2.4'>FRUIT JUICES GUAVA 0.33 L </option>
//                  <option value='2.4'>MANGOSTEEN MIXED 0.33 L </option>
//                  <option value='2.4'>COCO WATER & COCO MILK 0.33 L </option>
//                  <option value='3.9'>COCO WATER & COCO MILK 1 L </option>
//                  <option value='3.9'>FRUIT JUICES GUAVA 1 L </option>
//                  <option value='3.9'>MANGOSTEEN MIXED 1 L </option>
//                  <option value='3.9'>FRUIT JUICES MANGO 1 L </option>
//                  <option value='3.9'>COCONUT WATER 1 L </option></select>";
//
//                    echo '<div id="malee-price"><p>Price: </p></div> ';
//                    break;
//                default:
//                    echo 'Price: ' . $other->price . " lv. <br>";
//            }
//        }
//        else {
//            echo 'Price: '.$other->price . " lv. <br>";}
//        echo "<form action='' method='post'>";
//        echo "<input type='hidden' name='id' value='" . $other->id . "' >";
//        echo "<input type='submit' value='Choose' name='choose'>";
//        echo "</form><br></td></tr>";
//    }
 ?>
</table>
<script type="text/javascript">
        var category_id = <?= $category_id; ?>;
        getOthers(category_id,null );

        function updatePrice(clicked_id) {
            var price = document.getElementById(clicked_id).value;
            document.getElementById(clicked_id + '-price').innerHTML="<p>Price: " + price + " lv. </p>";
        }
</script>
</body>

