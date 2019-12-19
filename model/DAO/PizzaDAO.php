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
                $pizzas[] = new Pizza($row["id"], $row["name"],
                                      $row["img_url"], $row["modified"],
                                      $ingredients, $price, $row["category"], 1, 2);
            }

            return $pizzas;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function getIngredients($id = null) {
        try {
            $pdo = getPDO();

            $sql = "SELECT i.id AS id, i.name AS name, i.price AS price, c.name AS category 
                    FROM ingredients AS i 
                    JOIN categories  AS c ON(c.id = i.category_id)
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
                $ingredients[] = new Ingredient($row["id"], $row["name"], $row["category"], $row["price"]);
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
}