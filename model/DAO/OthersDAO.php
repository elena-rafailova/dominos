<?php


namespace model\DAO;
use model\Others;
use PDO;
use PDOException;

include_once "DBConnector.php";

class OthersDAO
{

    public function getAll($category_id, $filter=null)
    {
        try {
            $pdo = getPDO();

            $sql = "SELECT * FROM others WHERE others_category_id=? ";
            if (isset($filter)) {
                $sql .= " AND filter =?";
            }
            $stmt = $pdo->prepare($sql);
            if (isset($filter)) {
                $stmt->execute([$category_id,$filter]);
            } else {
                $stmt->execute([$category_id]);
            }

            $rows = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $rows;
        } catch (PDOException $e) {
            echo "Something went wrong". $e->getMessage();
            return false;
        }
    }

    public function getOther($id,$category_id)
    {
        try {
            $pdo = getPDO();

            $sql = "SELECT id, name, img_url,description, modified, filter, others_category_id, price FROM others WHERE id=? AND others_category_id=?;";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id, $category_id]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $other = new Others($row["id"], $row["name"] ,$row["img_url"],
                $row["description"], $row["modified"], $row["filter"] ,$row["others_category_id"], $row["price"]);
            return $other;
        }catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}