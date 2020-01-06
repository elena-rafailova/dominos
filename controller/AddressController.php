<?php


namespace controller;

use model\Address;
use model\DAO\AddressDAO;

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
            $city = $_POST['city'];
            $phone_number = $_POST['phone_number'];
            $floor = $_POST['floor'];
            $building_number = $_POST['building_number'];
            $apartment_number = $_POST['apartment_number'];
            $entrance = $_POST['entrance'];
            $msg = $this->validationOfInput($street_name, $name, $phone_number, $building_number, $apartment_number, $entrance);
            if ($msg != '') {
                echo $msg;
                include_once "view/add_address.php";
            } else {
                $address = new Address($phone_number, $city, $name, $street_name, $street_number, $building_number, $entrance, $floor, $apartment_number);
                $user_id = json_decode($_SESSION['logged_user'])->id;
                AddressDAO::add($address, $user_id);
                header("Location: index.php?target=address&action=show");
            }
        }
    } else {
        include_once "view/add_address.php";
    }
}

function change()
{
    if (isset($_POST['change'])) {
        if (isset($_POST['street_name']) && isset($_POST['street_number']) && isset($_POST['phone_number'])) {
            if ($_POST['name'] != '') {
                $name = $_POST['name'];
            } else {
                $name = 'Empty Title';
            }
            $street_name = $_POST['street_name'];
            $street_number = $_POST['street_number'];
            $city = $_POST['city'];
            $phone_number = $_POST['phone_number'];
            $floor = $_POST['floor'];
            $building_number = $_POST['building_number'];
            $apartment_number = $_POST['apartment_number'];
            $entrance = $_POST['entrance'];
            $msg = $this->validationOfInput($street_name, $name, $phone_number, $building_number, $apartment_number, $entrance);
            if ($msg != '') {
                echo $msg;
                include_once "view/main.php";
            } else {
                $id = $_POST['id'];
                $address = new Address($phone_number, $city, $name, $street_name, $street_number, $building_number, $entrance, $floor, $apartment_number);
                AddressDAO::change($address, $id);
                header("Location: index.php?target=address&action=show");
            }
        }
    }
}

function delete(){
    if(isset($_POST['delete'])){
            $id = $_POST['id'];
            AddressDAO::delete($id);
            header("Location: index.php?target=address&action=show");
        }
}

function show() {
    $user_id = json_decode($_SESSION['logged_user'])->id;
    $addresses = AddressDAO::get($user_id);
    include_once "view/addresses.php";
}

function getAddresses() {
    $user_id = json_decode($_SESSION['logged_user'])->id;
    $addresses = AddressDAO::get($user_id);
    echo json_encode($addresses, JSON_UNESCAPED_UNICODE);
}

function validationOfInput($street_name, $name , $phone_number, $building_number='' ,$apartment_number='' ,$entrance= '') {
    $msg = '';

    if((preg_match("^[a-zA-Z0-9\s]+$^",$name)) !=1 ) {
        $msg .= " Invalid address name format. <br> ";
    }
    if((preg_match("^[a-zA-Z0-9\s.\"']+$^", $street_name)) != 1) {
        $msg .= " Invalid street name format. <br> ";
    }
    if((preg_match("^[0-9\s+]+$^", $phone_number)) != 1) {
        $msg .= " Invalid phone number format. <br> ";
    }
    if($building_number!= ''){
        if(!ctype_alnum($building_number)){
            $msg .= " Invalid building number format.<br> ";
        }
    }
    if($apartment_number!= ''){
        if(!ctype_alnum($apartment_number)){
            $msg .= " Invalid apartment number format. <br> ";
        }
    }
    if($entrance!= ''){
        if(!ctype_alnum($entrance)){
            $msg .= " Invalid entrance format. <br> ";
        }
    }
        return $msg;
}
}