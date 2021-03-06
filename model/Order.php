<?php


namespace model;


class Order implements \JsonSerializable
{
    private $id;
    private $user_id;
    private $date_created;
    private $status_name;
    private $delivery_address;
    private $restaurant;
    private $payment_type;
    private $price;
    private $items;
    private $comment;

    public function __construct($id, $user_id, $date_created, $status_name, $delivery_address, $restaurant,
                                $payment_type, $price, $items, $comment = null) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->date_created = $date_created;
        $this->status_name = $status_name;
        $this->delivery_address = $delivery_address;
        $this->restaurant = $restaurant;
        $this->payment_type = $payment_type;
        $this->price = $price;
        $this->items = $items;
        $this->comment = $comment;
    }

    public function getId() {
        return $this->id;
    }

    public function getComment() {
        return $this->comment;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getItems() {
        return $this->items;
    }

    public function getDateCreated()
    {
        return $this->date_created;
    }

    public function getStatusName()
    {
        return $this->status_name;
    }

    public function setItems($items): void
    {
        $this->items = $items;
    }

    public function getPaymentType() {
        return $this->payment_type;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getRestaurant() {
        return $this->restaurant;
    }

    public function getDeliveryAddress() {
        return $this->delivery_address;
    }

    public function jsonSerialize()
    {
       return get_object_vars($this);
    }
}