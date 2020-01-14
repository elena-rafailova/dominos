<?php


namespace model\DAO;

use PDO;
use model\DAO\BaseDAO;
use model\Ingredient;

class IngredientDAO extends BaseDAO {

    public function getPrice($id) {
        $pdo = parent::getPDO();

        $sql = "SELECT price FROM ingredients WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC)["price"];
    }


    public function getAll() {
        $pdo = parent::getPDO();

        $sql = "SELECT i.id AS id, i.name AS name, i.price AS price, i.category_id AS category
                FROM ingredients AS i ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([]);

        $ingredients = [];
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($rows) == 0) {
            return false;
        }

        foreach ($rows as $row) {
            $ingredients[] = new Ingredient($row["id"], $row["name"], $row["category"], $row["price"]);
        }

        return $ingredients;
    }

    public function getById($id) {
        $pdo = parent::getPDO();

        $sql = "SELECT i.id AS id, i.name AS name, i.price AS price
                FROM ingredients AS i 
                WHERE i.id= ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row === false) {
            return false;
        }

        return new Ingredient($row["id"], $row["name"], null, $row["price"]);
    }
}