<?php

namespace model\DAO;

use model\Address;
use model\Restaurant;
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
        $sql ="SELECT * FROM addresses as a JOIN users_have_addresses as uha ON a.id = uha.address_id
                        WHERE uha.user_id = ?";
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
        $sql = "UPDATE addresses SET phone_number=?, city_id=? , name=?, street_name=?, street_number=?, building_number=?,
                entrance=?, floor=?, apartment_number=?
               WHERE id= ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($phone_number, $city_id, $name, $street_name, $street_number, $building_number, $entrance, $floor, $apartment_number, $id));
        return true;
    }

    function delete($id){
        try {
            //DELETE addresses, users_have_addresses FROM addresses
            // JOIN users_have_addresses ON addresses.id=users_have_addresses.address_id WHERE addresses.id=?;
            //
            //CHANGED FK in DB to be ON DELETE CASCADE in uha - address_id
            $pdo = parent::getPDO();
            $pdo->beginTransaction();
            $sql = "DELETE FROM addresses WHERE id= ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            $sql2="DELETE FROM users_have_addresses WHERE address_id =?";
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

//    function getAllRestaurantAddresses() {
//        try {
//            $pdo = getPDO();
//
//            $sql = "SELECT r.id AS restaurant_id, r.name, a.id AS address_id, a.city_id,
//                    a.street_name, a.street_number, a.building_number
//                    FROM restaurants AS r
//                    JOIN addresses AS a ON (r.address_id = a.id)";
//            $stmt = $pdo->prepare($sql);
//            $stmt->execute([]);
//
//            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
//            $restaurants = [];
//            foreach ($rows as $row) {
//                $address = new Address($row["address_id"], $row["city_id"], null, $row["street_name"],
//                    $row["street_number"], $row["building_number"], null, null, null);
//                $restaurants[] = new Restaurant($row["restaurant_id"], $row["name"], $address);
//
//            }
//
//            return $restaurants;
//        } catch (PDOException $e) {
//            echo $e->getMessage();
//        }
//    }
}