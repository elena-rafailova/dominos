<?php


namespace model\DAO;
include_once "DBConnector.php";

use model\Pizza;
use model\Ingredient;
use PDO;
use PDOException;


class PizzaDAO
{

    function getAll() {
        try {
            $pdo = getPDO();

            $sql = "SELECT id, name, img_url, modified, category FROM pizzas";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            $pizzas = [];
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {
                $ingredients = [];
                $ingredients = $this->getIngredients($row["id"]);
                $pizzas[] = new Pizza($row["id"], $row["name"],
                                      $row["img_url"], $row["modified"],
                                      $ingredients, $row["category"]);
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function getIngredients($id = null) {
        try {
            $pdo = getPDO();

            $sql = "SELECT i.id AS id, i.name AS name, c.name AS category 
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
                $ingredients[] = new Ingredient($row["id"], $row["name"], $row["category"]);
            }
            return $ingredients;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}