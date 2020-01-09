<?php
include_once "main.php";
include_once "menu-list.php";
use model\Other;
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
    if(!isset($others)) {
        header("Location: index.php?target=other&action=getOthers&category_id=$category_id");
    }
}
 ?>

<body>
<?php switch($category_id) {
    case 1:
        echo "<h1>Our starters: </h1>
        <a href='index.php?target=other&action=getOthersInfo&category_id=1&filter=1'><button>New</button></a>
        <a href='index.php?target=other&action=getOthersInfo&category_id=1&filter=2'><button>Vegetarian</button></a>";
        break;
    case 2:
        echo "<h1>Our chicken: </h1>
        <a href='index.php?target=other&action=getOthersInfo&category_id=2&filter=3'><button>Spicy</button></a>";
        break;
    case 3:
        echo "<h1>Our pasta: </h1>
        <a href='index.php?target=other&action=getOthersInfo&category_id=3&filter=1'><button>New</button></a>
        <a href='index.php?target=other&action=getOthersInfo&category_id=3&filter=3'><button>Spicy</button></a>";
        break;
    case 4:
        echo "<h1>Our salads: </h1>
        <a href='index.php?target=other&action=getOthersInfo&category_id=4&filter=2'><button>Vegetarian</button></a>";
        break;
    case 5:
        echo "<h1>Our sandwiches: </h1>";
        break;
    case 6:
        echo "<h1>Our dips: </h1>
        <a href='index.php?target=other&action=getOthersInfo&category_id=6&filter=1'><button>New</button></a>
        <a href='index.php?target=other&action=getOthersInfo&category_id=6&filter=3'><button>Spicy</button></a>";
        break;
    case 7:
        echo "<h1>Our desserts: </h1>
        <a href='index.php?target=other&action=getOthersInfo&category_id=7&filter=4'><button>Desserts</button></a>
        <a href='index.php?target=other&action=getOthersInfo&category_id=7&filter=5'><button>Ice Creams</button></a>";
        break;
    case 8:
        echo "<h1>Our drinks: </h1>";
        break;
} ?>
<table id="others">
<?php
 /** @var Other $other $other */
foreach ($others as $other) {
        echo "<tr>";
        echo "<td><img src='".$other->getImgUrl()."' class='product_img' /><br>";
        echo $other->getName() . "<br>";
        echo "<hr>";
        echo $other->getDescription() . "<br>";

        echo "<input type='button' onclick='getOptions(category_id, this.id);' id='".$other->getId().".choose' value='Choose' name='choose'>";

        echo "<form id='".$other->getId().".order' style='display: none' action='index.php?target=cart&action=addToCart' method='post'>";
        echo "<input type='hidden' id='".$other->getId().".id' name='other_id' value=".$other->getId().">";
        echo "<input type='hidden' id='".$other->getId().".category_id' name='category_id' value='$category_id'>";
                if($category_id == 8) {
            switch ($other->getName()) {
                case 'SPRITE':
                case 'FANTA':
                case 'COCA-COLA ZERO':
                case 'COCA-COLA':
                    echo "Size: <select name='drink_size' id='".$other->getId()."' onchange='updatePrice(this.id);'>
                  <option value='2'>0.5 L </option>
                  <option value='3.1'>1.5 L </option></select>";

                    echo "<p id='".$other->getId().".price_for_one' style='display:none;'>".$other->getPrice()."</p>
                            <div>Price: <span id='".$other->getId().".price'>".$other->getPrice()."</span> BGN</div>";
                    break;
                case 'MINERAL WATER':
                    echo "Size: <select name='drink_size' id='".$other->getId()."' onchange='updatePrice(this.id);'>
                  <option value='1'>0.5 L </option>
                  <option value='1.5'>1.5 L </option></select>";

                    echo "<p id='".$other->getId().".price_for_one' style='display:none;'></p>
                            <div>Price: <span id='".$other->getId().".price'>".$other->getPrice()."</span> BGN</div>";
                    break;
                case 'ZAGORKA':
                    echo "Size: <select name='drink_size' id='".$other->getId()."' onchange='updatePrice(this.id);'>
                  <option value='1.7'>0.33 L </option>
                  <option value='2.6'>1 L </option></select>";

                    echo "<p id='".$other->getId().".price_for_one' style='display:none;'></p>
                            <div>Price: <span id='".$other->getId().".price'>".$other->getPrice()."</span> BGN</div>";
                    break;
                case 'MALEE':
                    echo "Size: <select name='drink_size' id='".$other->getId()."' onchange='updatePrice(this.id);'>
                  <option value='2.4'>COCONUT WATER 0.33 L </option>
                  <option value='2.4'>FRUIT JUICES MANGO 0.33 L </option>
                  <option value='2.4'>FRUIT JUICES GUAVA 0.33 L </option>
                  <option value='2.4'>MANGOSTEEN MIXED 0.33 L </option>
                  <option value='2.4'>COCO WATER & COCO MILK 0.33 L </option>
                  <option value='3.9'>COCO WATER & COCO MILK 1 L </option>
                  <option value='3.9'>FRUIT JUICES GUAVA 1 L </option>
                  <option value='3.9'>MANGOSTEEN MIXED 1 L </option>
                  <option value='3.9'>FRUIT JUICES MANGO 1 L </option>
                  <option value='3.9'>COCONUT WATER 1 L </option></select>";

                    echo "<p id='".$other->getId().".price_for_one' style='display:none;'></p>
                            <div>Price: <span id='".$other->getId().".price'>".$other->getPrice()."</span> BGN</div>";
                    break;
                default:
                    echo "<p id='".$other->getId().".price_for_one' style='display:none;'>".$other->getPrice()."</p>
                             <div>Price: <span id='".$other->getId().".price'>".$other->getPrice()."</span> BGN</div>";
                    break;}
                } else {
                    echo "<p id='".$other->getId().".price_for_one' style='display:none;'>".$other->getPrice()."</p>
                             <div>Price: <span id=\"".$other->getId().".price\">".$other->getPrice()."</span> BGN</div>";
                }

        echo "<h6>Quantity</h6>
        <input type='button' value='-' id='".$other->getId()."' onclick='decrementVal(this.id)'>
        <input type='text' min='1' max='100' name='quantity' id='".$other->getId().".quantity' value='1' required readonly>
        <input type='button' value='+' id='".$other->getId()."' onclick='incrementVal(this.id)'>";
        echo "<input type='submit' name='add_to_cart' value='Add'></form><br></td></tr>";
    }
 ?>
</table>

<script type="text/javascript">

    var category_id = <?= $category_id; ?>;

    function updatePrice(clicked_id) {
            var price = document.getElementById(clicked_id).value;
            document.getElementById(clicked_id + '.price_for_one').innerText= price;
            document.getElementById(clicked_id + '.price').innerText=price;
        }
</script>
</body>

