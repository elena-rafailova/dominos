<?php

namespace model\DAO;

include_once "DBConnector.php";
use model\Address;
use PDO;
use PDOException;

class AddressDAO
{
    //todo deleteAddress, changeAddress, getAddresses(by user id)

    static function add(Address $address, $user_id){
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
            $pdo = getPDO();
            $pdo->beginTransaction();
            $sql ="INSERT INTO addresses (phone_number, city_id, name, street_name, street_number, building_number, entrance, floor, apartment_number)
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($phone_number,$city_id,$name,$street_name, $street_number,$building_number,$entrance,$floor,$apartment_number));
            $address->setId($pdo->lastInsertId());
//            if($pdo->lastInsertId() > 0){
//                return true;
//            }
//            else{
//                return false;
//            }
            $sql2= "INSERT INTO users_have_addresses (user_id, address_id) VALUES (?, ?)";
            $stmt2 = $pdo->prepare($sql2);
            $stmt2->execute(array($user_id, $address->getId()));

            $pdo->commit();

        }
        catch (PDOException $e) {
            $pdo->rollBack();
            echo "Something went wrong". $e->getMessage();
        }
    }
}