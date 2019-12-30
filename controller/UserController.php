<?php


namespace controller;

use model\DAO\UserDAO;
use model\User;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;


require_once 'model/DAO/config.php';
class UserController
{
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

function sendMail($email, $token)
    {
        // Create the Transport
        $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))->setUsername(EMAIL)
            ->setPassword(PASSWORD);

    // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);

        $body = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Reset your password</title>
            </head>
            <body>
                <p>
                    Hello dear user,
                    <br>
                    You have sent a request to change your password.
                    Please do so if you still wish by clicking on the link below.
                    Please be noted that the link will expire in an hour.
                </p>
                <a href="http://localhost/dominos/index.php?target=user&action=resetPassword&token=' . $token . '">Reset you password here.</a>
            </body>
            </html>';
        // Create a message
        $message = (new Swift_Message('Reset your password'))
            ->setFrom(EMAIL)
            ->setTo($email)
            ->setBody($body, 'text/html');

        // Send the message
        $result = $mailer->send($message);
    }

function forgotPassword() {
    $msg='';
    if(isset($_POST['forgot_password'])) {
        if(isset($_POST['email'])){
            $email=$_POST['email'];
            if (!(filter_var($email, FILTER_VALIDATE_EMAIL))) {
                $msg .= " Invalid email format. <br> ";
            }else {
                $user = UserDAO::checkUser($email);
                if (!$user) {
                    $msg .= "User with that email doesn't exist! <br>";
                } else {
                    $user_id = $user->id;
                    $token = bin2hex(random_bytes(50));
                    $expFormat = mktime(
                    date("H"), date("i"), date("s"), date("m"), date("d")+1, date("Y"));
                    $expDate = date("Y-m-d H:i:s", $expFormat);
                    UserDAO::addToken($user_id, $token, $expDate);
                    $this->sendMail($email, $token);
                    include_once "view/forgot_message.php";
                }
            }
        }
    }
//    if($msg!= '') {
//        echo $msg;
//    }
}
function resetPassword() {
    //from email
    if(isset($_GET['token'])){
        $token=$_GET['token'];
        $curDate = date("Y-m-d H:i:s");
        $user = UserDAO::getUserByToken($token);
        if(!$user) {
        echo "<h2>Invalid Link</h2>
        <p>The link is invalid/expired or you have already used the link in which case it is 
        deactivated.</p>";
        }
        else {
            $_SESSION['id'] = $user->id;
            $expDate = $user->exp_date;
            if ($expDate >= $curDate){
                include_once "view/reset_password.php";
            }
            else {
                UserDAO::deleteToken($_SESSION['id']);
                echo "<h2>Invalid Link</h2>
                <p>The link is expired.You are trying to use the expired link which 
                    is valid only 24 hours (1 days after request).<br /><br /></p>";
            }
        }
    }
}

function changePassword() {
    if(isset($_POST['change_password'])) {
       $password = $_POST['new_password'];
       $confirm_password = $_POST['confirm_password'];
        $msg = '';
        if ($password === $confirm_password) {
            if (!(preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $password))) {
                $msg .= " Wrong password input. Password should be at least 8 characters -
                containing at least one lowercase, one uppercase letter, one digit
                and one special character. <br> ";
            } else {
                    $user_id = $_SESSION['id'];
                    $new_password = password_hash($password, PASSWORD_BCRYPT);
                    $update = UserDAO::updatePassword($new_password, $user_id);
                    if($update) {
                        header("Location: index.php?view=login");
                    } else {
                        echo 'Mistake in UserDAO!';
                    }
                }
            }
        else {
            $msg .= " Passwords don't match! <br> ";
        }
        if($msg!='') {
            echo $msg;
        }

    }
}

    public function greet() {
        $user = json_decode($_SESSION['logged_user']);
        echo 'Hello, '.$user->first_name;
        die();
    }
}

