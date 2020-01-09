<?php


namespace model\DAO;

use model\Other;
use PDO;

class OtherDAO extends BaseDAO {

    public function getAll($category_id, $filter=null)
    {
            $pdo = parent::getPDO();

            $sql = "SELECT id, name, img_url, description, filter, others_category_id, price FROM others 
                    WHERE others_category_id=? ";
            if (isset($filter)) {
                $sql .= " AND filter =? ;";
            }
            $stmt = $pdo->prepare($sql);
            if (isset($filter)) {
                $stmt->execute([$category_id,$filter]);
            } else {
                $stmt->execute([$category_id]);
            }

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $others = [];
            foreach ($rows as $row) {
                $others [] = new Other($row["id"], $row["name"] , $row["img_url"],
                    $row["description"], $row["filter"] ,$row["others_category_id"], $row["price"]);
            }
            return $others;
    }

    public function getOther($id,$category_id)
    {
            $pdo = parent::getPDO();

            $sql = "SELECT id, name, img_url,description, filter, others_category_id, price FROM others 
                    WHERE id=? AND others_category_id=?;";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id, $category_id]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $other = new Other($row["id"], $row["name"] , $row["img_url"],
                $row["description"], $row["filter"] ,$row["others_category_id"], $row["price"]);
            return $other;

    }
}