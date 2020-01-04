<?php


namespace model\DAO;
include_once "DBConnector.php";

use PDO;
use PDOException;
use model\Ingredient;

class IngredientDAO
{
    static public function getPrice($id) {
        try {
            $pdo = getPDO();

            $sql = "SELECT price FROM ingredients WHERE id=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    static public function getByCategory($id) {
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

    public static function getById($id) {
        try {
            $pdo = getPDO();

            $sql = "SELECT i.id AS id, i.name AS name, i.price AS price
                    FROM ingredients AS i 
                    WHERE i.id= ?";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return new Ingredient($row["id"], $row["name"], null, $row["price"]);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}