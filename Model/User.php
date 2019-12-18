<?php


namespace model;


class User
{
    private $id;
    private $first_name;
    private $last_name;
    private $email;
    private $password;
    private $date_created;

   public function __construct($first_name,$last_name,$email,$password) {
       $this->first_name = $first_name;
       $this->last_name  = $last_name;
       $this->email      = $email;
       $this->password   = $password;
   }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }


    public function getLastName()
    {
        return $this->last_name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }


}