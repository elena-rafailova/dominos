<?php


namespace model\DAO;

include_once "DBConnector.php";
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
        try{
            $pdo = getPDO();
            $sql ="INSERT INTO users (first_name,  last_name, email, password)
                   VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($first_name, $last_name, $email, $password));
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
            $row = $stmt->fetch(PDO::FETCH_OBJ);
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
    static function editUser(User $user)
    {
        try {
            $first_name = $user->getFirstName();
            $last_name  = $user->getLastName();
            $password   = $user->getPassword();
            $id = $user->getId();
            $pdo = getPDO();
            $sql = "UPDATE users SET first_name =? , last_name=?, password=? WHERE id=?;";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($first_name,$last_name,$password,$id));
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}