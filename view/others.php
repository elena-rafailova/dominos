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
    if (!isset($others)) {
        header("index.php?target=others&action=showOthers&category_id =". $category_id);
    }
}

?>

<body>
<?php switch($category_id) {
    case 1:
        echo "<h1>Our starters: </h1>
        <a href='index.php?target=others&action=showOthers&category_id=1&filter=1'><button>New</button></a>
        <a href='index.php?target=others&action=showOthers&category_id=1&filter=2'><button>Vegetarian</button></a>";
        break;
    case 2:
        echo "<h1>Our chicken: </h1>
        <a href='index.php?target=others&action=showOthers&category_id=2&filter=3'><button>Spicy</button></a>";
        break;
    case 3:
        echo "<h1>Our pasta: </h1>
        <a href='index.php?target=others&action=showOthers&category_id=3&filter=1'><button>New</button></a>
        <a href='index.php?target=others&action=showOthers&category_id=3&filter=3'><button>Spicy</button></a>";
        break;
    case 4:
        echo "<h1>Our salads: </h1>
        <a href='index.php?target=others&action=showOthers&category_id=4&filter=2'><button>Vegetarian</button></a>";
        break;
    case 5:
        echo "<h1>Our sandwiches: </h1>";
        break;
    case 6:
        echo "<h1>Our dips: </h1>
        <a href='index.php?target=others&action=showOthers&category_id=6&filter=1'><button>New</button></a>
        <a href='index.php?target=others&action=showOthers&category_id=6&filter=3'><button>Spicy</button></a>";
        break;
    case 7:
        echo "<h1>Our desserts: </h1>
        <a href='index.php?target=others&action=showOthers&category_id=7&filter=4'><button>Desserts</button></a>
        <a href='index.php?target=others&action=showOthers&category_id=7&filter=5'><button>Ice Creams</button></a>";
        break;
    case 8:
        echo "<h1>Our drinks: </h1>";
        break;
} ?>
<table>
    <?php
    foreach ($others as $other) {
        echo "<tr>";
        echo "<td><img src='" . $other->img_url. "' /><br>";
        echo $other->name . "<br>";
        echo "<hr>";
        echo $other->description . "<br>";
        echo 'Price: '.$other->price . " lv. <br>";
        echo "<form action='' method='post'>";
        echo "<input type='hidden' name='id' value='" . $other->id . "' >";
        echo "<input type='submit' value='Choose' name='choose'>";
        echo "</form><br></td></tr>";
    }
    ?>
</table>
</body>

