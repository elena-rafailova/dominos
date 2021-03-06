<?php


namespace controller;

use exceptions\AuthorizationException;
use exceptions\BadRequestException;
use exceptions\NotFoundException;
use model\Cart;
use model\DAO\UserDAO;
use model\User;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;


require_once 'model/DAO/config.php';
class UserController
{

    function main() {
        include_once "view/main.php";
    }

    function register()
    {
        $userDAO = new UserDAO();
        if (isset($_POST["register"])) {
            if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email'])
                && isset($_POST['password']) && isset($_POST['verify_password'])) {
                $msg = $this->validationOfInput($_POST['first_name'], $_POST['last_name'], $_POST['email'],
                    $_POST['password'], $_POST['verify_password']);
                if ($userDAO->checkUser($_POST["email"])) {
                    throw new BadRequestException( "User with that email already exists");
                } elseif ($msg != '') {
                    throw new BadRequestException("$msg");
                } else {
                    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
                    /** @var User $user */
                    $user = new User(null,$_POST["first_name"], $_POST["last_name"], $_POST["email"], $password);
                    $newUser= $userDAO->addUser($user);
                    if($newUser != false) {
                        $_SESSION["logged_user"] = json_encode($newUser);
                        $_SESSION["cart"] = new Cart();
                        header("Location: index.php?target=pizza&action=showAll");
                    }
                }
            }
        }
    }

    function login()
    {
        $userDAO = new UserDAO();
        if (isset($_POST['login'])) {
            if (isset($_POST['email']) && isset($_POST['password'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];
                $userObj = $userDAO->checkUser($email);
                if (!$userObj) {
                throw  new AuthorizationException("User with that email doesn't exist.");
                } else {
                    if (password_verify($password, $userObj->getPassword())) {
                        /** @var User $user */
                        $user = json_encode($userObj);
                        $_SESSION['logged_user'] = $user;
                        $_SESSION["cart"] = new Cart();
                       header("Location: index.php?target=pizza&action=showAll");
                    } else {
                        throw new AuthorizationException("Invalid password or email! Try again.");
                    }
                }
            }
        }
    }

    function userExists() {
        $userDAO = new UserDAO();
        if (isset($_GET["email"])){
            $email = $_GET["email"];
        $userObj = $userDAO->checkUser($email);
        if($userObj) {
            $msg="exists";
            echo json_encode($msg);
            }
        else {
            $msg="doesn't";
            echo json_encode($msg);
        }
         }
    }

       function editView() {
        include_once "view/edit_view.php";
    }
    function editSuccess() {
        include_once "view/change_profile_view.php";
    }

    function edit()
    {
        $userDAO = new UserDAO();
        if (isset($_POST['edit'])) {
        $logged_user= json_decode($_SESSION['logged_user']);
            if (isset($_POST['first_name']) && isset($_POST['last_name'])) {
                $password =$logged_user->password;
        if (isset($_POST['password']) && !empty($_POST['password']) && $_POST["password"]!= '' ) {
            if (password_verify($_POST['password'], $password)) {
                if (isset($_POST['new_password']) && isset($_POST['verify_password'])) {
                    $msg = $this->validationOfInput($_POST['first_name'], $_POST['last_name'], $_POST['email'],
                        $_POST['new_password'], $_POST['verify_password']);
                    if ($msg != '') {
                        throw new BadRequestException("$msg");
                    } else {
                        $password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
                        $email = $logged_user->email;
                        $user = new User($logged_user->id,$_POST["first_name"], $_POST["last_name"], $email, $password);
                        $userDAO->editUser($user);
                        $_SESSION['logged_user'] = json_encode($user);
                       header("Location: index.php?target=user&action=editSuccess");
                    }
                        }
                    } else {
                        throw new BadRequestException("The current password you've entered is wrong!");
                    }
                } elseif($_POST["first_name"] == $logged_user->first_name &&
                    $_POST['last_name'] == $logged_user->last_name &&
                    $_POST['email'] == $logged_user->email) {
                        header("Location: index.php?target=user&action=editView");
                    } else{
                        $msg = $this->validationOfInput($_POST['first_name'], $_POST['last_name'], $_POST['email']);
                        if ($msg != '') {
                            throw new BadRequestException("$msg");
                        } else {
                            $email =$logged_user->email;
                            $user = new User($logged_user->id,$_POST["first_name"], $_POST["last_name"], $email, $password);
                            $userDAO->editUser($user);
                            $_SESSION['logged_user'] = json_encode($user);
                            header("Location: index.php?target=user&action=editSuccess");
                        }
                    }
                }
            }
        }

    function logout()
    {
        unset($_SESSION);
        session_destroy();
        header("Location: index.php?target=user&action=main");
        exit;
    }

    function validationOfInput($first_name, $last_name, $email, $password = 1, $verify_password = 1)
    {
        $pattern  = '/^[a-zA-Z\p{Cyrillic}\s\-]+$/u';
        $msg = '';
        if(!preg_match ($pattern, $first_name) || !preg_match ($pattern, $last_name)) {
            $msg .= " Invalid name format. It should contain only letters. <br> ";
        }
        if (mb_strlen($first_name) < 3 || mb_strlen($last_name) < 3) {
            $msg .= " Invalid first or last name. They should be at least 3 characters. <br> ";
        }
        if (!(filter_var($email, FILTER_VALIDATE_EMAIL))) {
            $msg .= " Invalid email format. <br> ";
        }
        if ($password != 1 && $verify_password != 1) {
            if ($password === $verify_password) {
                if (!(preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $password))) {
                    $msg .= " Wrong password input. Password should be at least 8 characters -
                containing at least one lowercase, one uppercase letter, one digit
                and one special character. <br> ";
                }
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
        if($result == 0) {
            throw new NotFoundException("Failed to send mail.Please try again.");
        }
    }

    function forgotPassword()
    {
        $msg = '';
        $userDAO = new UserDAO();

        if (isset($_POST['forgot_email'])) {
            $email = $_POST['forgot_email'];
            if (!(filter_var($email, FILTER_VALIDATE_EMAIL))) {
                $msg .= " Invalid email format. <br> ";
            } else {
                $user = $userDAO->checkUser($email);
                if (!$user) {
                    $msg .= "User with that email doesn't exist! <br>";
                } else {
                    $user_id = $user->getId();
                    $token = bin2hex(random_bytes(50));
                    $expFormat = mktime(
                        date("H") + 1, date("i"), date("s"), date("m"), date("d"), date("Y"));
                    $expDate = date("Y-m-d H:i:s", $expFormat);
                    $userDAO->addToken($user_id, $token, $expDate);
                    $this->sendMail($email, $token);
                }
            }
        }

    if($msg!= '') {
       throw new BadRequestException("$msg");
    }
    }

    function resetPassword()
    {
        //from email
        $userDAO = new UserDAO();
        if (isset($_GET['token'])) {
            $token = $_GET['token'];
            $curDate = date("Y-m-d H:i:s");
            $user = $userDAO->getUserByToken($token);
            if (!$user) {
                throw new BadRequestException("<h2>Invalid Link</h2>
                        <p>The link is invalid/expired or you have already used the link in which case it is 
                        deactivated.</p>");
            } else {
                $_SESSION['id'] = $user->id;
                $expDate = $user->exp_date;
                if ($expDate >= $curDate) {
                    include_once "view/reset_password_view.php";
                } else {
                    $userDAO->deleteToken($_SESSION['id']);
                    throw new BadRequestException("<h2>Invalid Link</h2>
                        <p>The link is expired.You are trying to use the expired link which 
                         is valid only 1 hour.<br /><br /></p>");
                }
            }
        }
    }

    function changePassword()
    {
        $userDAO = new UserDAO();
        if (isset($_POST['change_password'])) {
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
                    $update = $userDAO->updatePassword($new_password, $user_id);
                    if ($update) {
                        header("Location: index.php?view=login");
                    } else {
                        throw new BadRequestException("Something went wrong. Please try again.");
                    }
                }
            } else {
                $msg .= " Passwords don't match! <br> ";
            }
            if ($msg != '') {
                throw new BadRequestException("$msg");
            }

        }
    }

    function deliveryMethod()
    {
        if (isset($_POST["resId"]) && $_POST["resId"] != "ERR-NO-ADDR") {
            unset($_SESSION["delivery"]);
            $_SESSION["carry_out"] = $_POST["resId"];
            echo json_encode(["msg" => "success"]);
            die();
        }
        if (isset($_POST["addrId"]) && $_POST["addrId"] != "ERR-NO-ADDR") {
            unset($_SESSION["carry_out"]);
            $_SESSION["delivery"] = $_POST["addrId"];
            echo json_encode(["msg" => "success"]);
            die();
        }
        echo json_encode(["msg" => "error"]);
    }

}

