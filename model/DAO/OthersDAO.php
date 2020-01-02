<?php


namespace model\DAO;
use PDO;
use PDOException;

include_once "DBConnector.php";

class OthersDAO
{

    public static function getAll($category_id, $filter=null)
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
}