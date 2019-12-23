<?php


namespace model\DAO;
include_once "DBConnector.php";

use model\Pizza;
use model\Ingredient;
use PDO;
use PDOException;


class PizzaDAO {

    public function getAll($category = null) {
        try {
            $pdo = getPDO();

            $sql = "SELECT id, name, img_url, modified, category FROM pizzas";
            if (isset($category)) {
                $sql .= " WHERE category=?";
            }
            $stmt = $pdo->prepare($sql);
            if (isset($category)) {

                $stmt->execute([$category]);
            } else {
                $stmt->execute([]);
            }

            $pizzas = [];
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {
                $ingredients = $this->getIngredients($row["id"]);
                $price = 0;
                foreach ($ingredients as $ingredient) {
                    $price += $ingredient->getPrice();

                }
//                $sql1 = "SELECT name FROM doughs WHERE id = ?";
//                $stmt1 = $pdo->prepare($sql1);
//                $stmt1->execute([1]);
//
//                $dough = $stmt1->fetch(PDO::FETCH_ASSOC)["name"];
//
//                $sql1 = "SELECT name FROM sizes WHERE id = ?";
//                $stmt1 = $pdo->prepare($sql1);
//                $stmt1->execute([2]);
//
//                $size = $stmt1->fetch(PDO::FETCH_ASSOC)["name"];
                $pizzas[] = new Pizza($row["id"], $row["name"],
                                      $row["img_url"], $row["modified"],
                                      $ingredients, $price, $row["category"], 1, 2);
            }

            return $pizzas;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getIngredients($id = null) {
        try {
            $pdo = getPDO();

            $sql = "SELECT i.id AS id, i.name AS name, i.price AS price
                    FROM ingredients AS i 
                    JOIN pizzas_have_ingredients AS phi ON (phi.ingredient_id = i.id)
                    JOIN pizzas AS p ON (phi.pizza_id = p.id)";
            if (isset($id)) {
                $sql .= " WHERE p.id = ?";
            }
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);

            $ingredients = [];
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {
                $ingredients[] = new Ingredient($row["id"], $row["name"], null, $row["price"]);
            }



            return $ingredients;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getPriceFromDoughAndSize($doughId = 1, $sizeId = 2) {
        try {
            $pdo = getPDO();
            $sql = "SELECT s.price + d.price AS sum 
                    FROM doughs AS d JOIN sizes AS s 
                    WHERE s.id = ? AND d.id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$sizeId, $doughId]);

            return $stmt->fetch(PDO::FETCH_ASSOC)["sum"];

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getDoughsOrSizes($dough = true) {
        try {
            $pdo = getPDO();

            $sql = "SELECT id, name, price ";
            if ($dough) {
                $sql .= "FROM doughs";
            } else {
                $sql .= ", slices FROM sizes";
            }
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getPizza($id) {
        try {
            $pdo = getPDO();

            $sql = "SELECT id, name, img_url, category FROM pizzas WHERE id=?;";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);


            $pizza = $stmt->fetch(PDO::FETCH_ASSOC);
            $ingredients = $this->getIngredients($id);
            $price = 0;
            foreach ($ingredients as $ingredient) {
                $price += $ingredient->getPrice();
            }

            $pizza = new Pizza($pizza["id"], $pizza["name"], $pizza["img_url"], 0,
                $ingredients, $price, $pizza["category"], 1, 2);

            return $pizza;
        }catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getIngredientsByCategory($id) {
        try {
            $pdo = getPDO();

            $sql = "SELECT i.id AS id, i.name AS name, i.price AS price
                    FROM ingredients AS i 
                    WHERE i.category_id = ?";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);

            $ingredients = [];
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {
                $ingredients[] = new Ingredient($row["id"], $row["name"], null, $row["price"]);
            }

            return $ingredients;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getIngredientById($id) {
        try {
            $pdo = getPDO();

            $sql = "SELECT i.id AS id, i.name AS name, i.price AS price
                    FROM ingredients AS i 
                    WHERE i.id= ?";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $ingredient = new Ingredient($row["id"], $row["name"], null, $row["price"]);

            return $ingredient;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /** @var Pizza $pizza
     *  @return int
     */
    public function addNew($pizzaName, $ingredients) {
        $pdo = getPDO();
        try {

            $pdo->beginTransaction();
            $sql = "INSERT INTO pizzas(name) VALUES(?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$pizzaName]);

            $pizza_id = $pdo->lastInsertId();
            /** @var Ingredient $item */
            foreach ($ingredients as $item) {
                $sql2 = "INSERT INTO pizzas_have_ingredients(pizza_id, ingredient_id) VALUES(?, ?)";
                $stmt2 = $pdo->prepare($sql2);
                $stmt2->execute([$pizza_id, $item->getId()]);
            }

            $pdo->commit();
            return $pizza_id;
        }catch (PDOException $e) {
            $pdo->rollBack();
            echo $e->getMessage();
        }
    }
}