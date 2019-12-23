<?php


namespace controller;


use model\Address;
use model\DAO\AddressDAO;

class AddressController
{
//todo delete, change, show
function add () {
    //todo validation of address data
    if(isset($_POST['add'])) {
        $name= $_POST['name'];
        $street_name= $_POST['street_name'];
        $street_number= $_POST['street_number'];
        $city= $_POST['city'];
        $phone_number= $_POST['phone_number'];
        $floor= $_POST['floor'];
        $building_number= $_POST['building_number'];
        $apartment_number= $_POST['apartment_number'];
        $entrance= $_POST['entrance'];

        $address = new Address($phone_number,$city,$name,$street_name,$street_number,$building_number,$entrance,$floor,$apartment_number);
        $user_id = json_decode($_SESSION['logged_user'])->id;
        AddressDAO::add($address, $user_id);
        echo "Successfully added new address. <br>";
        include_once "view/addresses.php";

    }
}
function change() {}
function delete(){}
function show() {}
}