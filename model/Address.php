<?php


namespace model;


class Address
{
    private $id;
    private $phone_number;
    private $city_id;
    private $name;
    private $street_name;
    private $street_number;
    private $building_number;
    private $entrance;
    private $floor;
    private $apartment_number;
    private $date_created;

    public function __construct($phone_number, $city_id, $name=null, $street_name, $street_number,
                                $building_number=null, $entrance=null, $floor=null, $apartment_number=null)
    {
        $this->phone_number=$phone_number;
        $this->city_id=$city_id;
        $this->name=$name;
        $this->street_name=$street_name;
        $this->street_number=$street_number;
        $this->building_number=$building_number;
        $this->entrance=$entrance;
        $this->floor=$floor;
        $this->apartment_number=$apartment_number;
    }


}