<?php


namespace controller;

use model\DAO\UserDAO;
use model\User;

class UserController
{
//TODO forgotten password
function register() {
    if(isset($_POST["register"])){
        if(isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email'])
            && isset($_POST['password']) && isset($_POST['verify_password'])) {
            $msg = $this->validationOfInput($_POST['first_name'], $_POST['last_name'], $_POST['email'],
                $_POST['password'], $_POST['verify_password']);
            if(UserDAO::checkUser($_POST["email"])){
                echo "User with that email already exists";
                include_once "view/register.php";
            }
            elseif($msg != '') {
               echo $msg;
               include_once "view/register.php";
            }
            else {
                $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
                $user = new User($_POST["first_name"], $_POST["last_name"], $_POST["email"], $password );
                UserDAO::addUser($user);
                $_SESSION["logged_user"] = json_encode($user);
                echo "Successful registration. <br>";
                include_once "view/main.php";
            }
        }
    }
}

function login() {
    if(isset($_POST['login'])) {
        if(isset($_POST['email']) && isset($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $userObj = UserDAO::checkUser($email);
            if(!$userObj) {
                echo "Invalid password or email! Try again.";
            }
            else {
                if(password_verify($password, $userObj->password)) {
                    $user=json_encode($userObj);
                    $_SESSION['logged_user'] = $user;
                    echo "Successful login! <br>";
                    include_once "view/main.php";
                }
                else {
                    echo 'Invalid email or password.Try again.';
                }
            }
        }
    }
}

function edit()
{
    if (isset($_POST['edit'])) {
        if (!isset($_SESSION["logged_user"])) {
            header("Location: index.php");
        }
        if (isset($_POST['first_name']) && isset($_POST['last_name'])) {
            $password=json_decode($_SESSION['logged_user'])->password;
            if(isset($_POST['password']) && !empty($_POST['password'])) {
                if(password_verify($_POST['password'],$password)){
                if (isset($_POST['new_password']) && isset($_POST['verify_password'])) {
                    $msg = $this->validationOfInput($_POST['first_name'], $_POST['last_name'], $_POST['email'],
                        $_POST['new_password'], $_POST['verify_password']);
                    if ($msg != '') {
                        echo $msg;
                        include_once "view/main.php";
                    } else {
                        $password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
                        $email = json_decode($_SESSION['logged_user'])->email;
                        $user = new User($_POST["first_name"], $_POST["last_name"], $email, $password);
                        $user->setId(json_decode($_SESSION['logged_user'])->id);
                        UserDAO::editUser($user);
                        $_SESSION['logged_user'] = json_encode($user);
                        echo "Profile changed successfully. <br>";
                        include_once "view/main.php";
                    }
                }
                } else {
                    echo "The current password you've entered is wrong!";
                    include_once "view/main.php";
                    }
            }else {
                    $msg = $this->validationOfInput($_POST['first_name'], $_POST['last_name'], $_POST['email']);
                    if ($msg != '') {
                        echo $msg;
                        include_once "view/main.php";
                    }
                    else {
                        $email = json_decode($_SESSION['logged_user'])->email;
                        $user = new User($_POST["first_name"], $_POST["last_name"], $email, $password);
                        $user->setId(json_decode($_SESSION['logged_user'])->id);
                        UserDAO::editUser($user);
                        $_SESSION['logged_user'] = json_encode($user);
                        echo "Profile changed successfully. <br>";
                        include_once "view/main.php";
                    }
            }
        }
    }
}

function logout() {
    unset($_SESSION);
    session_destroy();
    header("Location: index.php?view=login");
    exit;
}

function validationOfInput($first_name, $last_name, $email, $password=1, $verify_password=1)
{
    $msg = '';
    if (!(ctype_alpha($first_name)) || !(ctype_alpha($last_name))) {
        $msg .= " Invalid name format. It should contain only letters. <br> ";
    }
    if (!(filter_var($email, FILTER_VALIDATE_EMAIL))) {
        $msg .= " Invalid email format. <br> ";
    }
    if($password != 1 && $verify_password != 1) {
        if ($password === $verify_password) {
            if (!(preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $password))) {
                $msg .= " Wrong password input. Password should be at least 8 characters -
                containing at least one lowercase, one uppercase letter, one digit
                and one special character. <br> "; }
        } else {
            $msg .= " Passwords don't match! <br> ";
        }
    }

       return $msg;
}

}

