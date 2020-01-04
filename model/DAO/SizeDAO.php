<?php


namespace model\DAO;
include_once "DBConnector.php";

use model\Size;
use PDO;
use PDOException;

class SizeDAO
{
    static public function getPrice($id) {
        try {
            $pdo = getPDO();

            $sql = "SELECT price FROM sizes WHERE id=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public static function getAll() {
        try {
            $pdo = getPDO();

            $sql = "SELECT id, name, price, slices FROM sizes ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $sizes = [];

            foreach ($rows as $row) {
                $sizes[] = new Size($row["id"], $row["name"], $row["price"], $row["slices"]);
            }

            return $sizes;

        }catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}