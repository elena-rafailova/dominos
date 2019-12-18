<?php


namespace model\DAO;

use model\User;
use PDO;
use PDOException;

class UserDAO
{
    static function addUser(User $user){
        $first_name = $user->getFirstName();
        $last_name  = $user->getLastName();
        $email      = $user->getEmail();
        $password   = $user->getPassword();
        $date = date('Y-m-d H:i:s');
        try{
            $pdo = getPDO();
            $sql ="INSERT INTO users (first_name,  last_name, email, password, date_created)
                   VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($first_name, $last_name, $email, $password, $date));
            $user->setId($pdo->lastInsertId());
                if($pdo->lastInsertId() > 0){
                    return true;
                }
                else{
                    return false;
                }
            }
        catch (PDOException $e) {
            echo "Something went wrong". $e->getMessage();
            }
    }
    static function checkUser($email)
    {
        try {
            $pdo = getPDO();
            $sql ="SELECT * FROM users WHERE email = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($email));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (empty($row)) {
                return false;
            } else {
                return $row;
            }
        }
        catch (PDOException $e) {
            echo "Something went wrong". $e->getMessage();
        }
    }
}