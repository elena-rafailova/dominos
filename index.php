<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use exceptions\BaseException;
require_once './vendor/autoload.php';

//AUTOCOMPLETE
spl_autoload_register(function ($class){
    $class = str_replace("\\", DIRECTORY_SEPARATOR, $class) . ".php";
    require_once  $class;
});

set_exception_handler("handleExceptions");
session_start();

$fileNotFoundFlag = false;
$controllerName = isset($_GET["target"]) ? $_GET["target"] : "base";
$methodName     = isset($_GET["action"]) ? $_GET["action"] : "baseFunc";

$controllerClassName = "\\controller\\" . ucfirst($controllerName) . "Controller";

function handleExceptions(Exception $exception){
    $status = $exception instanceof BaseException ? $exception->getStatusCode() : 500;
   $msg = $exception->getMessage();
    $html = "<h3>$msg</h3>";
    http_response_code($status);
    include_once "view/error.php" ;
    echo $html;

//    $obj = new stdClass();
//    $obj->msg = $exception->getMessage();
//    $obj->status = $status;
//    echo json_encode($obj);
}


if($controllerName == "base" && $methodName == "baseFunc"){
    if(!isset($_SESSION["logged_user"])) {
        header("Location: index.php?target=user&action=login");
    } else {
        header("Location: index.php?target=pizza&action=showAll");
    }
}
elseif (class_exists($controllerClassName)){
    $controller = new $controllerClassName();
     if (method_exists($controller,$methodName)){
        if (!($controllerName == "user" && in_array($methodName,array("login","register","forgotPassword","resetPassword", "changePassword")))){
            if (!isset($_SESSION["logged_user"])){
                header("Location: index.php?target=user&action=login");
                die();
            }
            if (isset($_SESSION["logged_user"]) &&
                in_array($methodName,array("login", "register", "forgotPassword", "resetPassword", "changePassword"))) {
                header("Location: index.php?target=pizza&action=showAll");
                die();
            }
        }
        else {
            $controller->$methodName();
        }
    }else{
        $fileNotFoundFlag = true;
    }
}else{
    $fileNotFoundFlag = true;
}
if ($fileNotFoundFlag){
   // header("Location: TO ERROR MESSAGE PAGE");
}

?>
