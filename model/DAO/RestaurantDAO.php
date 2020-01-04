<?php

namespace model\DAO;

use PDOException;
use PDO;

include "DBConnector.php";

class RestaurantDAO
{
static function getAll() {
    try {
        $pdo = getPDO();
        $sql = "SELECT r.id,a.phone_number,a.city_id,a.name,a.street_name,a.street_number, a.longitude, a.latitude
                FROM restaurants AS r JOIN addresses AS a ON (r.address_id=a.id) ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_OBJ);
        if($rows > 0){
            return $rows;
        }
        else {
            return false;
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
}