<?php


namespace controller;

use model\DAO\UserDAO;
use model\User;

class UserController
{
//TODO edit
function register() {
    if(isset($_POST["register"])){
        $err = false;
        $msg = "";
        //TODO validate password!!! And more validations to be added
        if(UserDAO::checkUser($_POST["email"])){
            $msg =  "User already exists";
            $err = true;
        }
        if(!$err) {
            $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
            $user = new User($_POST["first_name"], $_POST["last_name"], $_POST["email"], $password );
            UserDAO::addUser($user);
            $arrayUser = (array) $user;
            $_SESSION["logged_user"] = $arrayUser;
            $msg = "Successful registration.";
            include_once "view/main.php";
        }
        else{
            echo $msg;
            //include_once "view/register.php";
        }

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
            $password=$_SESSION['logged_user']['password'];
            if(isset($_POST['password']) && password_verify($_POST['password'],$_SESSION['logged_user']['password'] ) ) {
                if (isset($_POST['new_password']) && isset($_POST['verify_password']) && $_POST['new_password'] === $_POST['verify_password']) {
                    $password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
                }
            }
            $user = array('first_name' => $_POST["first_name"], 'last_name'=> $_POST["last_name"] , 'password'=>$password, 'id'=>$_SESSION['logged_user']['id']);
        }
        UserDAO::editUser($user);
        $user['email'] = $_SESSION['logged_user']['email'];
        $_SESSION['logged_user'] = $user;
        echo "Profile changed successfully.";
//            header("Location: index.php?action=main");
    } else {
        echo "Something went wrong.";
    }

   }


function logout() {
    unset($_SESSION);
    session_destroy();
    echo "Session destroyed successfully!";
    include_once "index.php";
    header("Location: index.php?view=login");
    exit;
}



}

