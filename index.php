<?php

//AUTOCOMPLETE
spl_autoload_register(function ($class){
    $class = str_replace("\\", DIRECTORY_SEPARATOR, $class) . ".php";
    require_once  $class;
});

session_start();

$fileNotFoundFlag = false;
$controllerName = isset($_GET["target"]) ? $_GET["target"] : "base";
$methodName     = isset($_GET["action"]) ? $_GET["action"] : "baseFunction";
$controllerClassName = "\\Controller\\" . ucfirst($controllerName) . "Controller";

if (class_exists($controllerClassName)){
    $controller = new $controllerClassName();
    if($controllerName == "base" && $methodName == "baseFunction"){
        try{
            $controller->$methodName();
            die();
        }catch (Exception $exception){
            echo "error -> " . $exception->getMessage();
            die();
        }
    }
    if (method_exists($controller,$methodName)){
        if (!($controllerName == "user" && in_array($methodName,array("login","registration")))){
            if (!isset($_SESSION["logged_user"])){
                header("HTTP/1.0 401 Not Authorized");
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