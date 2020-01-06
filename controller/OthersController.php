<?php


namespace controller;

use model\DAO\OthersDAO;

class OthersController
{
//    function showOthers() {
//     include_once "view/others.php";
//    }

    function getOthersInfo() {
        if (!(isset($_GET['filter'])) && isset($_GET["category_id"])) {
            $category_id = $_GET["category_id"];
            //todo try catch
            $othersDAO = new OthersDAO();
            $others = $othersDAO->getAll($category_id);
        }
        elseif(isset($_GET['filter']) && isset($_GET["category_id"]) ) {
            $category_id = $_GET["category_id"];
            $filter = $_GET["filter"];
            //todo try catch
            $othersDAO = new OthersDAO();
            $others = $othersDAO->getAll($category_id,$filter);
        }
        else {
            $others="Error";
        }
//        echo json_encode($others, JSON_UNESCAPED_UNICODE);
        include_once "view/others.php";
    }


//    function getOther() {
//        if (isset($_GET["id"]) && isset($_GET["category_id"])) {
//            $other = Others::getOtherById($_GET["id"], $_GET["category_id"]);
//            echo json_encode($other, JSON_UNESCAPED_UNICODE);
//        }
//    }
}