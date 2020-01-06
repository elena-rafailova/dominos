<?php

namespace model\DAO;

use model\Dough;
use PDO;

class DoughDAO extends BaseDAO {

    public function getPrice($id) {
        $pdo = parent::getPDO();

        $sql = "SELECT price FROM doughs WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC)["price"];
    }


    public function getAll() {
        $pdo = parent::getPDO();

        $sql = "SELECT id, name, price FROM doughs ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $doughs = [];

        foreach ($rows as $row) {
            $doughs[] = new Dough($row["id"], $row["name"], $row["price"]);
        }

        return $doughs;
    }
}