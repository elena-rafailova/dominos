<?php


namespace model\DAO;

use model\Size;
use PDO;

class SizeDAO extends BaseDAO {
    public function getPrice($id) {
        $pdo = parent::getPDO();

        $sql = "SELECT price FROM sizes WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC)["price"];
    }

    public function getById($id) {
        $pdo = parent::getPDO();

        $sql = "SELECT id, name, price, slices FROM sizes WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return new Size($row["id"], $row["name"], $row["price"], $row["slices"]);
    }

    public function getAll() {
        $pdo = parent::getPDO();

        $sql = "SELECT id, name, price, slices FROM sizes ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $sizes = [];

        foreach ($rows as $row) {
            $sizes[] = new Size($row["id"], $row["name"], $row["price"], $row["slices"]);
        }

        return $sizes;
    }
}