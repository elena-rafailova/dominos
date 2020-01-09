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
    function register()
    {
        include_once "view/register.php";
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
                    $user = new User($_POST["first_name"], $_POST["last_name"], $_POST["email"], $password);
                    $userDAO->addUser($user);
                    $_SESSION["logged_user"] = json_encode($user);
                    $_SESSION["cart"] = new Cart();
                    //echo "Successful registration. <br>";
                    header("Location: index.php?target=pizza&action=showAll");
                }
            }
        }
    }

    function login()
    {
        include_once "view/login.php";
        $userDAO = new UserDAO();

        if (isset($_POST['login'])) {
            if (isset($_POST['email']) && isset($_POST['password'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];
                $userObj = $userDAO->checkUser($email);
                if (!$userObj) {
                throw  new AuthorizationException("Invalid password or email! Try again.");
                } else {
                    if (password_verify($password, $userObj->getPassword())) {
                        /** @var User $user */
                        $user = json_encode($userObj);
                        $_SESSION['logged_user'] = $user;
                        $_SESSION["cart"] = new Cart();
                        echo "Successful login! <br>";
                        header("Location: index.php?target=pizza&action=showAll");
                    } else {
                        throw new AuthorizationException("Invalid password or email! Try again.");
                    }
                }
            }
        }
    }

    function edit()
    {
        include_once "view/edit.php";
        $userDAO = new UserDAO();
        if (isset($_POST['edit'])) {
            if (isset($_POST['first_name']) && isset($_POST['last_name'])) {
                $password = json_decode($_SESSION['logged_user'])->password;
                if (isset($_POST['password']) && !empty($_POST['password'])) {
                    if (password_verify($_POST['password'], $password)) {
                        if (isset($_POST['new_password']) && isset($_POST['verify_password'])) {
                            $msg = $this->validationOfInput($_POST['first_name'], $_POST['last_name'], $_POST['email'],
                                $_POST['new_password'], $_POST['verify_password']);
                            if ($msg != '') {
                                throw new BadRequestException("$msg");
                            } else {
                                $password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
                                $email = json_decode($_SESSION['logged_user'])->email;
                                $user = new User($_POST["first_name"], $_POST["last_name"], $email, $password);
                                $user->setId(json_decode($_SESSION['logged_user'])->id);
                                $userDAO->editUser($user);
                                $_SESSION['logged_user'] = json_encode($user);
                                echo "Profile changed successfully. <br>";
                            }
                        }
                    } else {
                        throw new BadRequestException("The current password you've entered is wrong!");
                    }
                } else {
                    $msg = $this->validationOfInput($_POST['first_name'], $_POST['last_name'], $_POST['email']);
                    if ($msg != '') {
                        throw new BadRequestException("$msg");
                    } else {
                        $email = json_decode($_SESSION['logged_user'])->email;
                        $user = new User($_POST["first_name"], $_POST["last_name"], $email, $password);
                        $user->setId(json_decode($_SESSION['logged_user'])->id);
                        $userDAO->editUser($user);
                        $_SESSION['logged_user'] = json_encode($user);
                        echo "Profile changed successfully. <br>";
                    }
                }
            }
        }
    }

    function logout()
    {
        unset($_SESSION);
        session_destroy();
        header("Location: index.php?target=user&action=login");
        exit;
    }

    function validationOfInput($first_name, $last_name, $email, $password = 1, $verify_password = 1)
    {
        $msg = '';
        if (!(ctype_alpha($first_name)) || !(ctype_alpha($last_name))) {
            $msg .= " Invalid name format. It should contain only letters. <br> ";
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
        include_once "view/forgot_password.php";
        $userDAO = new UserDAO();
        if (isset($_POST['forgot_password'])) {
            if (isset($_POST['email'])) {
                $email = $_POST['email'];
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
                        include_once "view/forgot_message.php";
                    }
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
                    include_once "view/reset_password.php";
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
                        throw new BadRequestException("Something went wrong. Pleas try again.");
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
        if (isset($_POST["resId"])) {
            $_SESSION["carry_out"] = $_POST["resId"];
        }
        if (isset($_POST["addrId"])) {
            $_SESSION["delivery"] = $_POST["addrId"];
        }
    }

}

