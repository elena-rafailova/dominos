<?php


namespace model\DAO;
include_once "DBConnector.php";

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
}