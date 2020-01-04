<?php

namespace model\DAO;
include_once "DBConnector.php";

use model\Dough;
use model\Size;
use PDO;
use PDOException;

class DoughDAO
{
    static public function getPrice($id) {
        try {
            $pdo = getPDO();

            $sql = "SELECT price FROM doughs WHERE id=?";
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

            $sql = "SELECT id, name, price FROM doughs ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $doughs = [];

            foreach ($rows as $row) {
                $doughs[] = new Dough($row["id"], $row["name"], $row["price"]);
            }

            return $doughs;

        }catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}