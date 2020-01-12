<?php


namespace model\DAO;

use model\Pizza;
use model\Ingredient;
use model\Dough;
use model\Size;
use PDO;
use PDOException;


define("TRADITIONAL_DOUGH_ID", 1);
define("LARGE_SIZE_ID", 2);
define("NOT_MODIFIED_PIZZA", 0);

class PizzaDAO extends BaseDAO {

    public function getAll($category = null) {
        $pdo = parent::getPDO();

        $sql = "SELECT id, name, img_url, modified, category FROM pizzas WHERE modified=? ";
        if (isset($category) && $category != 0) {
            $sql .= " AND category=?";
        }
        $stmt = $pdo->prepare($sql);
        if (isset($category) && $category != 0) {
            $stmt->execute([NOT_MODIFIED_PIZZA,$category]);
        } else {
            $stmt->execute([NOT_MODIFIED_PIZZA]);
        }

        $pizzas = [];
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            $ingredients = $this->getIngredients($row["id"]);
            $pizzas[] = new Pizza($row["id"], $row["name"],
                                  $row["img_url"], $row["modified"],
                                  $ingredients, $row["category"]);
        }

        return $pizzas;
    }

    public function getIngredients($id = null) {
        $pdo = parent::getPDO();

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
    }

    public function getPriceFromDoughAndSize($doughId = TRADITIONAL_DOUGH_ID, $sizeId = LARGE_SIZE_ID) {
        $pdo = parent::getPDO();
        $sql = "SELECT s.price + d.price AS sum 
                FROM doughs AS d JOIN sizes AS s 
                WHERE s.id = ? AND d.id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$sizeId, $doughId]);

        return $stmt->fetch(PDO::FETCH_ASSOC)["sum"];
    }


    public function getPizza($id) {
        $pdo = parent::getPDO();

        $sql = "SELECT id, name, img_url, category, modified FROM pizzas WHERE id=?;";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);


        $pizza = $stmt->fetch(PDO::FETCH_ASSOC);
        $ingredients = $this->getIngredients($id);

        if (!$pizza || $pizza["modified"] == 1) {
            return false;
        }

        $pizza = new Pizza($pizza["id"], $pizza["name"], $pizza["img_url"], NOT_MODIFIED_PIZZA,
            $ingredients, $pizza["category"], new Dough(TRADITIONAL_DOUGH_ID), new Size(LARGE_SIZE_ID));

        return $pizza;

    }


    /** @var Pizza $pizza
     *  @return int
     */
    public function addNew($pizzaName, $ingredients) {
        $pdo = parent::getPDO();
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
            throw $e;
        }
    }
}