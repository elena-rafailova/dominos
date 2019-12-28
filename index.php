<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once './vendor/autoload.php';
//AUTOCOMPLETE
spl_autoload_register(function ($class){
    $class = str_replace("\\", DIRECTORY_SEPARATOR, $class) . ".php";
    require_once  $class;
});

session_start();

$fileNotFoundFlag = false;
$controllerName = isset($_GET["target"]) ? $_GET["target"] : "view";
$methodName     = isset($_GET["action"]) ? $_GET["action"] : "viewRouter";

$view           = isset($_GET["view"]) ? $_GET["view"] : "main";

$controllerClassName = "\\controller\\" . ucfirst($controllerName) . "Controller";

if (class_exists($controllerClassName)){
    $controller = new $controllerClassName();
    if($controllerName == "view"){
        if (isset($_SESSION["logged_user"])) {
            try {
                $controller->$methodName($view);
                die();
            } catch (Exception $exception) {
                echo "error -> " . $exception->getMessage();
                die();
            }
        } else {
            if ($view != 'login' && $view != 'register' && $view!= 'forgot_password' && $view!= 'reset_password') {
                try {
                    $controller->$methodName('login');
                    die();
                } catch (Exception $exception) {
                    echo "error -> " . $exception->getMessage();
                    die();
                }
            } else if ($view == 'login' || $view == 'register' || $view == 'forgot_password' || $view == 'reset_password') {
                try {
                    $controller->$methodName($view);
                    die();
                } catch (Exception $exception) {
                    echo "error -> " . $exception->getMessage();
                    die();
                }
            }
        }
    }  else if (method_exists($controller,$methodName)){
        if (!($controllerName == "user" && in_array($methodName,array("login","register","forgotPassword","resetPassword", "changePassword")))){
            if (!isset($_SESSION["logged_user"])){
                header("Location: index.php?view=login");
                die();
            }
        }
        try{
            $controller->$methodName();
        }catch (Exception $exception){
            echo "error -> " . $exception->getMessage();
            die();
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
