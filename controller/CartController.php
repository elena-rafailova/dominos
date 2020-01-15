<?php
namespace Controller;
use exceptions\BadRequestException;
use exceptions\NotFoundException;
use model\Cart;
use model\DAO\DoughDAO;
use model\DAO\IngredientDAO;
use model\DAO\OtherDAO;
use model\DAO\PizzaDAO;
use model\DAO\SizeDAO;
use function MongoDB\BSON\toJSON;

define("STATUS_PENDING", 1);
define("PAYMENT_TYPE_CASH", 1);

class CartController {
    public function seeCart() {
        include_once "view/cart_view.php";
    }

    public function addToCart()
    {
        $pizzaDAO = new PizzaDAO();
        if (isset($_POST["add_to_cart"])) {
            if (isset($_POST["pizza_id"]) && isset($_POST["dough"]) && isset($_POST["size"]) && isset($_POST["sauces"])) {

                $pizza = $pizzaDAO->getPizza($_POST["pizza_id"]);
                if (!isset($pizza) || $pizza === false ) {
                    throw new NotFoundException("Pizza not found!");
                }

                $ingredientsIds = array_merge($_POST["sauces"] ?? [], $_POST["cheeses"] ?? [],
                    $_POST["herbs"] ?? [], $_POST["meats"] ?? [], $_POST["vegetables"] ?? [], $_POST["miscellaneous"] ?? []);
                $ingredients = [];

                foreach ($ingredientsIds as $ingredient) {
                    $ingredientDAO = new IngredientDAO();
                    $newIngr = $ingredientDAO->getById($ingredient);
                    if ($newIngr === false) {
                        throw new NotFoundException("Ingredient not found!");
                    }
                    $ingredients[] = $newIngr;
                }
                if ($pizza->getIngredients() != $ingredients) {
                    $pizza->setIngredients($ingredients);
                    $pizza->setModified(true);
                }
                $doughDAO = new DoughDAO();
                $dough = $doughDAO->getById($_POST["dough"]);

                if ($dough === false ) {
                    throw new NotFoundException("Dough not found!");
                }

                $pizza->setDough($dough);

                $sizeDAO = new SizeDAO();
                $size = $sizeDAO->getById($_POST["size"]);

                if ($size === false) {
                    throw new NotFoundException("Size not found!");
                }

                $pizza->setSize($size);

                $price_for_one = 0;
                if (isset($_POST["price_for_one"]) && $_POST["price_for_one"] > 0) {
                    $price_for_one = $_POST["price_for_one"];
                } else {
                    throw new BadRequestException("Invalid price!");
                }

                if (isset($_POST["quantity"]) && $_POST["quantity"] >= MIN_QUANTITY && $_POST["quantity"] <= MAX_QUANTITY) {
                    $pizza->setQuantity(intval($_POST["quantity"]));
                    $pizza->setPrice($price_for_one);

                    if (!$_SESSION["cart"]->addProduct($pizza)) {
                        throw new BadRequestException("Maximum quantity is 100!");
                    }
                    header("Location: index.php?target=pizza&action=showAll");
                    die();
                } else {
                    throw new BadRequestException("Invalid quantity!");
                }
            } else if (isset($_POST["other_id"]) && isset($_POST["category_id"])) {
                json_decode($_SESSION['logged_user']);
                $id = $_POST["other_id"];
                $category_id = $_POST["category_id"];
                $otherDAO = new OtherDAO();
                $other = $otherDAO->getOther($id, $category_id );
                if (!isset($other) || $other === false) {
                    throw new NotFoundException("Product not found!");
                }
                if (isset($_POST["quantity"]) && $_POST["quantity"] >= MIN_QUANTITY && $_POST["quantity"] <= MAX_QUANTITY) {
                    $other->setQuantity($_POST["quantity"]);
                } else {
                    throw new BadRequestException("Invalid quantity!");
                }
                $price_for_one = $other->getPrice();
                $other->setPrice($price_for_one);
                if (!$_SESSION["cart"]->addProduct($other)) {
                    throw new BadRequestException("Maximum quantity is 100!");
                }
                header("Location: index.php?target=other&action=showOthers&&category_id=" . $category_id);
                die();
            } else {
                throw new BadRequestException("Invalid item!");
            }
        }
    }

    function get() {
        if ($_SESSION["cart"]->isCartEmpty()) {
            echo json_encode(["empty"=>"true"]);
        }else {
            echo json_encode(["empty"=>"false", "cart" => $_SESSION["cart"]]);
        }
    }

    function addQuantity() {
        if (isset($_GET["id"])) {
            if (!array_key_exists($_GET["id"], $_SESSION["cart"]->getProducts())) {
                throw new NotFoundException("Product not found!");
            }
            $products = $_SESSION["cart"]->getProducts();
            if ($products[$_GET["id"]]->getQuantity() >= 100) {
                echo json_encode(["error" => "true"]);
                die();
            }
            $_SESSION["cart"]->increaseQuantity($_GET["id"]);
            echo json_encode(["error" => "false", "cart"=> $_SESSION["cart"]]);
        } else {
            throw new BadRequestException("Could not add to quantity!");
        }
    }

    function subtractQuantity() {
        if (isset($_GET["id"])) {
            $productId = $_GET["id"];
            if (!array_key_exists($_GET["id"], $_SESSION["cart"]->getProducts())) {
                throw new NotFoundException("Product not found!");
            }
            $_SESSION["cart"]->decreaseQuantity($productId);
            $_SESSION["cart"]->setProducts(array_values($_SESSION["cart"]->getProducts()));
            if ($_SESSION["cart"]->isCartEmpty()) {
                $_SESSION["cart"] = new Cart();
            }
            echo json_encode($_SESSION["cart"]);
        } else {
            throw new BadRequestException("Could not subtract from quantity!");
        }
    }
}