<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use exceptions\BaseException;
use exceptions\NotFoundException;

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
    $html = "<!doctype html>
                <html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\"
          content=\"width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"ie=edge\">
    <title>ERROR </title>
    <link rel=\"stylesheet\" href=\"styles/styles.css\">
    <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css\">
    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js\"></script>
    <script src=\"https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js\"></script>
    <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js\"></script>


    <link rel=\"stylesheet\" href=\"https://use.fontawesome.com/releases/v5.6.3/css/all.css\" integrity=\"sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/\" crossorigin=\"anonymous\">

</head>
<body>
<div id=\"main_header\" class=\"nav navbar\">
    <a class=\"navbar pull-left navbar-left\" href=\"index.php\"><img src=\"uploads/dominos_logo.svg\"></a>
     <a href=\"index.php?target=user&action=main\"><button class=\"navbar btn btn-light\">Back to main </button></a>
</div>
<div class=\"container text-center center\">
  <h2 class=\"font-weight-bold text-center\">ERROR: $status </h2>
  <h3 class=\"font-weight-bold text-center\">$msg </h3>
<div id=\"error_img\" >
  
</div>
</div>
<div>
</div>
</body>
</html>";
    http_response_code($status);
    echo $html;

//    $obj = new stdClass();
//    $obj->msg = $exception->getMessage();
//    $obj->status = $status;
//    echo json_encode($obj);
}

if (class_exists($controllerClassName)){
$controller = new $controllerClassName();
    if (isset($_SESSION["logged_user"])) {
        if($controllerName == "base" && $methodName == "baseFunc"){
                $controller->$methodName();
                die();
        }
    } if (method_exists($controller,$methodName)){
        if (!($controllerName == "user" && in_array($methodName,array("userExists","main","login","register","forgotPassword","resetPassword", "changePassword")))){
            if (!isset($_SESSION["logged_user"])){
                header("Location: index.php?target=user&action=main");
                die();
            }
        }
        if (isset($_SESSION["logged_user"]) && in_array($methodName,array("userExists", "main","login", "register", "forgotPassword", "resetPassword", "changePassword"))) {
            header("Location: index.php?target=pizza&action=showAll");
            die();
        } else {
            $controller->$methodName();
        }
    }else{
        $fileNotFoundFlag = true;
    }
}else{
    $fileNotFoundFlag = true;
}
if ($fileNotFoundFlag){
   throw new NotFoundException("File not found!");
}

?>
