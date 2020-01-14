<?php


namespace controller;

use exceptions\AuthorizationException;
use exceptions\BadRequestException;
use exceptions\NotFoundException;
use model\Address;
use model\City;
use model\DAO\AddressDAO;
use model\DAO\UserDAO;

class AddressController
{
function add () {
    if(isset($_POST['add'])) {
        if(isset($_POST['street_name']) && isset($_POST['street_number']) && isset($_POST['phone_number'])) {
            if ($_POST['name'] != '') {
                $name = $_POST['name'];
            } else {
                $name = 'Empty Title';
            }
            $street_name = $_POST['street_name'];
            $street_number = $_POST['street_number'];
            $city_id = $_POST['city'];
            $phone_number = $_POST['phone_number'];
            $floor = $_POST['floor'];
            $building_number = $_POST['building_number'];
            $apartment_number = $_POST['apartment_number'];
            $entrance = $_POST['entrance'];
            $addressDAO = new AddressDAO();
            $cities= $addressDAO->getCities();
            $filtered =  array_filter($cities, function($city) use ($city_id) {
                return $city->getId() == $city_id;
            });
            if(empty($filtered)) {
                throw new  NotFoundException("City not found!");
            }

            $msg = $this->validationOfInput($street_name, $name, $phone_number, $floor,$street_number, $building_number, $apartment_number, $entrance);
            if ($msg != '') {
                throw new BadRequestException("$msg");
            } else {
                $address = new Address($phone_number, $city_id, $name, $street_name, $street_number, $building_number, $entrance, $floor, $apartment_number);
                $user_id = json_decode($_SESSION['logged_user'])->id;
                $userDAO= new UserDAO();
                $userExists = $userDAO->checkUserById($user_id);
                if(!$userExists) {
                    throw new AuthorizationException("The user doesn't exist!");
                }
                $addressDAO = new AddressDAO();
                $user_addresses = $addressDAO->get($user_id);
                if($user_addresses!= false) {
                foreach ($user_addresses as $user_address) {
                    if($user_address->name == $name && $user_address->street_name == $street_name && $user_address->street_number == $street_number &&
                    $user_address->city_id == $city_id && $user_address->phone_number == $phone_number && $user_address->floor == $floor &&
                    $user_address->building_number == $building_number && $user_address->apartment_number == $apartment_number &&
                    $user_address->entrance == $entrance) {
                        throw new  BadRequestException("This address already exists!");
                    }
                }
                }
                try{
                    $addressDAO->add($address, $user_id);
                } catch(\PDOException $e) {
                    throw new BadRequestException("Something went wrong!");
                }

                header("Location: index.php?target=address&action=show");
            }
        }
    } else {
        $addressDAO = new AddressDAO();
        $cities= $addressDAO->getCities();
        include_once "view/add_address_view.php";
    }
}

function change()
{
        if(isset($_POST["change"]))
        if (isset($_POST['street_name']) && isset($_POST['street_number']) && isset($_POST['phone_number'])) {
            if ($_POST['name'] != '') {
               $name = $_POST['name'];
            } else {
                $name = 'Empty Title';
            }
            $street_name = $_POST['street_name'];
            $street_number = $_POST['street_number'];
            $city_id = $_POST['city'];
            $phone_number = $_POST['phone_number'];
            $floor = $_POST['floor'];
            $building_number = $_POST['building_number'];
            $apartment_number = $_POST['apartment_number'];
            $entrance = $_POST['entrance'];
            $msg = $this->validationOfInput($street_name, $name, $phone_number, $floor,$street_number, $building_number, $apartment_number, $entrance);
            if ($msg != '') {
               throw new BadRequestException("$msg");
            } else {
                $id = $_POST['id'];
                $address = new Address($phone_number, $city_id, $name, $street_name, $street_number, $building_number, $entrance, $floor, $apartment_number);
                $addressDAO = new AddressDAO();
                $cities = $addressDAO->getCities();
                $filtered =  array_filter($cities, function($city) use ($city_id) {
                    return $city->getId() == $city_id;
                });
                if(empty($filtered)) {
                    throw new  NotFoundException("City not found!");
                }
                $user_id = json_decode($_SESSION['logged_user'])->id;
                $user_addresses = $addressDAO->get($user_id);
                if($user_addresses!= false) {
                foreach ($user_addresses as $user_address) {
                    if($user_address->name == $name && $user_address->street_name == $street_name && $user_address->street_number == $street_number &&
                        $user_address->city_id == $city_id && $user_address->phone_number == $phone_number && $user_address->floor == $floor &&
                        $user_address->building_number == $building_number && $user_address->apartment_number == $apartment_number &&
                        $user_address->entrance == $entrance) {
                        header("Location: index.php?target=address&action=show");
                    }
                }
                    $addressDAO->change($address, $id);
                    header("Location: index.php?target=address&action=show");
                } else {
                    throw new NotFoundException("Addresses not found!");
                }

            }
        }
}

function delete(){
    $addressDAO = new AddressDAO();
    if(isset($_POST['delete'])){
        $user_id = json_decode($_SESSION['logged_user'])->id;
        $userDAO= new UserDAO();
        $userExists = $userDAO->checkUserById($user_id);
        if(!$userExists) {
            throw new AuthorizationException("The user doesn't exist!");
        }
        $address_id = $_POST['id'];
        $user_addresses = $addressDAO->get($user_id);
        if($user_addresses!= false) {
            foreach ($user_addresses as $user_address) {
                print_r($user_address->id);
                var_dump($address_id);
                if($user_address->id == $address_id)
                {
                    $addressDAO->delete($address_id,$user_id);
                    header("Location: index.php?target=address&action=show");
                }
            }
        }
       else {
           throw new BadRequestException("Cannot delete non-existing address!");
       }
    }
}

function show() {
    include_once "view/addresses_view.php";
}


function getAddresses() {
    $user_id = json_decode($_SESSION['logged_user'])->id;
    $addressDAO = new AddressDAO();
    $addresses = $addressDAO->get($user_id);
    echo json_encode($addresses, JSON_UNESCAPED_UNICODE);
}

function validationOfInput($street_name, $name , $phone_number, $floor,$street_number, $building_number='' ,$apartment_number='' ,$entrance= '') {
    $msg = '';

    $pattern  = "/^[a-zA-Z\p{Cyrillic}0-9\s\-]+$/u";

    if((preg_match($pattern,$name)) !=1 ) {
        $msg .= " Invalid address name format. <br> ";
    }
    if((preg_match("/^[a-zA-Z\p{Cyrillic}0-9\s\-.\"']+$/u", $street_name)) != 1) {
        $msg .= " Invalid street name format. <br> ";
    }
    if((preg_match("^[0-9\s+]+$^", $phone_number)) != 1) {
        $msg .= " Invalid phone number format. <br> ";
    }
    if((is_numeric($floor) && $floor < 0) || !is_numeric($floor) || (is_numeric($floor) && $floor > 1000)) {
      $msg.= "Invalid floor number. <br>";
    }
    if((is_numeric($street_number) && $street_number < 1) || !is_numeric($street_number) || (is_numeric($street_number) && $street_number > 1000)) {
        $msg.= "Invalid street number. <br> ";
    }
    if($building_number!= ''){
        if(!ctype_alnum($building_number) ||  (is_numeric($building_number) && $building_number < 0) || (is_numeric($building_number) && $building_number > 1000)){
            $msg .= " Invalid building number format.<br> ";
        }
    }
    if($apartment_number!= ''){
        if(!ctype_alnum($apartment_number) ||  (is_numeric($apartment_number) && $apartment_number < 0) || (is_numeric($apartment_number) && $apartment_number > 1000)){
            $msg .= " Invalid apartment number format. <br> ";
        }
    }
    if($entrance!= ''){
        if(!ctype_alnum($entrance) || (is_numeric($entrance) && $entrance < 0) || (is_numeric($entrance) && $entrance > 1000)) {
            $msg .= " Invalid entrance format. <br> ";
        }
    }
        return $msg;
}
}