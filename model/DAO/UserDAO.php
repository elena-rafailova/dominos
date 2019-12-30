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

    static function addToken($user_id,$token,$expDate)
    {
            //add token to DB table
        try {
            $pdo = getPDO();
            $sql ="INSERT INTO password_reset(user_id, token, exp_date) VALUES (?,?,?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($user_id,$token,$expDate));
            return true;
        }
        catch (PDOException $e) {
            echo "Something went wrong". $e->getMessage();
            return false;
        }
    }

    static function getUserByToken($token)
    {
        //get user info by token
        try {
            $pdo = getPDO();
            $sql ="SELECT u.id,u.first_name,u.last_name,u.email, pr.exp_date FROM users AS u JOIN password_reset AS pr ON (u.id = pr.user_id) WHERE pr.token =?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($token));
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

    static function updatePassword($new_password, $user_id)
    {
        // update users with new pass and delete token from reset_password
        try {
            $pdo = getPDO();
            $pdo->beginTransaction();
            $sql = "UPDATE users SET password=? WHERE id=?;";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($new_password, $user_id));

            $sql2 = "DELETE FROM password_reset WHERE user_id = ? ";
            $stmt2 = $pdo->prepare($sql2);
            $stmt2->execute([$user_id]);

            $pdo->commit();
            return true;
        } catch (PDOException $e) {
            $pdo->rollBack();
            echo $e->getMessage();
            return false;
        }
    }

    static function deleteToken($user_id)
    {
        try {
            $pdo = getPDO();
            $sql = "DELETE FROM password_reset WHERE user_id = ? ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$user_id]);
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

}