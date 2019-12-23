<?php


namespace model;


class Address implements \JsonSerializable
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

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public function getId()
    {
        return $this->id;
    }


    public function getPhoneNumber()
    {
        return $this->phone_number;
    }


    public function getCityId()
    {
        return $this->city_id;
    }


    public function getName()
    {
        return $this->name;
    }


    public function getStreetName()
    {
        return $this->street_name;
    }


    public function getStreetNumber()
    {
        return $this->street_number;
    }


    public function getBuildingNumber()
    {
        return $this->building_number;
    }


    public function getEntrance()
    {
        return $this->entrance;
    }


    public function getFloor()
    {
        return $this->floor;
    }


    public function getApartmentNumber()
    {
        return $this->apartment_number;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

}