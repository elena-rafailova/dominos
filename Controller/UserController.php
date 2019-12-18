<?php


namespace controller;


use model\DAO\UserDAO;
use model\User;

class UserController
{
//TODO login, logout, register, edit
function register() {
    if(isset($_POST["register"])){
        $err = false;
        $msg = "";
        if(UserDAO::checkUser($_POST["email"])){
            $msg =  "User already exists";
            $err = true;
        }
        if(!$err) {
            $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
            $user = new User($_POST["first_name"], $_POST["last_name"], $_POST["email"], $password );
            UserDAO::addUser($user);
            $_SESSION["logged_user"] = $user;
            print_r($_SESSION["logged_user"]);
            $msg = "Successful registration.";
            //header("Location: View/main.php");
        }
        else{
            $msg= 'Unsuccessful';
            //include_once "View/register.html";
        }
        echo $msg;
    }
}
function login() {
    if(isset($_POST['login'])) {
        if(isset($_POST['email']) && isset($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $user = UserDAO::checkUser($email);
            if(!$user) {
                echo "Invalid password or email! Try again.";
            }
            else {
                if(password_verify($password, $user["password"])) {
                    $_SESSION['logged_user'] = $user;
                    print_r($_SESSION["logged_user"]);
                    echo "Successful login!";
                    include_once "View/main.php";
                }
                else {
                    echo 'Invalid email or password.Try again.';
                }
            }
        }
    }
}

}