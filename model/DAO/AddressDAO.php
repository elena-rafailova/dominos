<?php

namespace model\DAO;

use model\Address;
use model\City;
use PDO;
use PDOException;

class AddressDAO extends BaseDAO {

    function add(Address $address, $user_id){
        $phone_number = $address->getPhoneNumber();
        $city_id  = $address->getCityId();
        $name      = $address->getName();
        $street_name   = $address->getStreetName();
        $street_number   = $address->getStreetNumber();
        $building_number   = $address->getBuildingNumber();
        $entrance   = $address->getEntrance();
        $floor   = $address->getFloor();
        $apartment_number   = $address->getApartmentNumber();
        try{
            $pdo = parent::getPDO();
            $pdo->beginTransaction();
            $sql ="INSERT INTO addresses (phone_number, city_id, name, street_name, street_number, building_number, entrance, floor, apartment_number)
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($phone_number,$city_id,$name,$street_name, $street_number,$building_number,$entrance,$floor,$apartment_number));
            $address->setId($pdo->lastInsertId());
            $sql2= "INSERT INTO users_have_addresses (user_id, address_id) VALUES (?, ?)";
            $stmt2 = $pdo->prepare($sql2);
            $stmt2->execute(array($user_id, $address->getId()));

            $pdo->commit();

        }
        catch (PDOException $e) {
            $pdo->rollBack();
            throw  $e;
        }
    }

    function get($user_id) {
        $pdo = parent::getPDO();
        $sql ="SELECT a.id,a.phone_number,a.city_id,c.name AS city_name,a.name,a.street_name,
                a.street_number, a.building_number,a.entrance,a.floor,a.apartment_number
                FROM addresses as a JOIN users_have_addresses as uha ON a.id = uha.address_id
                JOIN cities AS c ON (c.id=a.city_id)
                WHERE uha.user_id = ? 
                ORDER BY  a.id ASC;";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id]);
        $rows = $stmt->fetchAll(PDO::FETCH_OBJ);
        if (empty($rows)) {
            return false;
        } else {
            return $rows;
        }
    }

    function change(Address $address, $id) {
        $phone_number = $address->getPhoneNumber();
        $city_id  = $address->getCityId();
        $name      = $address->getName();
        $street_name   = $address->getStreetName();
        $street_number   = $address->getStreetNumber();
        $building_number   = $address->getBuildingNumber();
        $entrance   = $address->getEntrance();
        $floor   = $address->getFloor();
        $apartment_number   = $address->getApartmentNumber();

        $pdo = parent::getPDO();
        $sql = "UPDATE addresses SET phone_number=?, city_id=? , name=?, street_name=?, street_number=?,
                building_number=?, entrance=?, floor=?, apartment_number=?
                WHERE id= ? ;";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($phone_number, $city_id, $name, $street_name, $street_number, $building_number, $entrance, $floor, $apartment_number, $id));
        return true;
    }

    function delete($id){
        try {
            //CHANGED FK in DB to be ON DELETE CASCADE in uha - address_id
            $pdo = parent::getPDO();
            $pdo->beginTransaction();
            $sql = "UPDATE addresses SET phone_number = NULL,name=NULL,street_name=NULL,street_number=NULL,building_number=NULL,
                     entrance=NULL,floor=NULL,apartment_number=NULL WHERE id= ? ;";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            $sql2="DELETE FROM users_have_addresses WHERE address_id =? ;";
            $stmt2= $pdo->prepare($sql2);
            $stmt2->execute([$id]);

            $pdo->commit();
            return true;
        }
        catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    function getCities() {
        $pdo = parent::getPDO();
        $sql ="SELECT id,name FROM cities ;";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $cities = [];
        foreach ($rows as $row) {
            $cities[] = new City($row["id"], $row["name"]);
        }
        if (empty($rows)) {
            return false;
        } else {
            return $cities;
        }
    }
}