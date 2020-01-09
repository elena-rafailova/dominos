<?php


namespace model\DAO;

use model\User;
use PDO;

class UserDAO extends BaseDAO {
    function addUser(User $user){
        $first_name = $user->getFirstName();
        $last_name  = $user->getLastName();
        $email      = $user->getEmail();
        $password   = $user->getPassword();


        $pdo = parent::getPDO();

        $sql ="INSERT INTO users (first_name,  last_name, email, password)
               VALUES (?, ?, ?, ?) ;";
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

    function checkUser($email)
    {
        $pdo = parent::getPDO();
        $sql ="SELECT id, first_name,last_name, email, password FROM users WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($email));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($row)) {
            return false;
        } else {
            $row = new User($row["id"], $row["first_name"], $row["last_name"], $row["email"], $row["password"]);
            return $row;
        }
    }

    function editUser(User $user)
    {
        $first_name = $user->getFirstName();
        $last_name  = $user->getLastName();
        $password   = $user->getPassword();
        $id = $user->getId();

        $pdo = parent::getPDO();
        $sql = "UPDATE users SET first_name =? , last_name=?, password=? WHERE id=?;";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($first_name,$last_name,$password,$id));
        return true;
    }

    function addToken($user_id,$token,$expDate)
    {
        //add token to DB table
        $pdo = parent::getPDO();
        $sql ="INSERT INTO password_reset(user_id, token, exp_date) VALUES (?,?,?) ;";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($user_id,$token,$expDate));
        return true;

    }

    function getUserByToken($token)
    {
        //get user info by token
        $pdo = parent::getPDO();
        $sql ="SELECT u.id,u.first_name,u.last_name,u.email, pr.exp_date FROM users AS u 
                JOIN password_reset AS pr ON (u.id = pr.user_id) WHERE pr.token =? ;";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($token));
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        if (empty($row)) {
            return false;
        } else {
            return $row;
        }
    }

    function updatePassword($new_password, $user_id)
    {
        // update users with new pass and delete token from reset_password
        try {
            $pdo = parent::getPDO();
            $pdo->beginTransaction();
            $sql = "UPDATE users SET password=? WHERE id=? ;";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($new_password, $user_id));

            $sql2 = "DELETE FROM password_reset WHERE user_id = ? ;";
            $stmt2 = $pdo->prepare($sql2);
            $stmt2->execute([$user_id]);

            $pdo->commit();
            return true;
        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    function deleteToken($user_id)
    {
        $pdo = parent::getPDO();
        $sql = "DELETE FROM password_reset WHERE user_id = ? ; ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id]);
        return true;
    }

}