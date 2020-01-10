<?php


namespace controller;

use exceptions\BadRequestException;
use model\DAO\OtherDAO;

class OtherController
{
        function showOthers() {
         include_once "view/others_view.php";
        }

    function getOthersInfo() {
        if (!(isset($_GET["filter"])) && isset($_GET["category_id"])) {
            $category_id = $_GET["category_id"];
            $otherDAO = new OtherDAO();
            $others = $otherDAO->getAll($category_id);
        }
        elseif(isset($_GET["filter"]) && isset($_GET["category_id"]) ) {
            $category_id = $_GET["category_id"];
            $filter = $_GET["filter"];
            $otherDAO = new OtherDAO();
            $others = $otherDAO->getAll($category_id,$filter);
        }
        else {
            throw new BadRequestException("Error- the products you search for cannot be found!");
        }

        echo json_encode($others, JSON_UNESCAPED_UNICODE);
        //include_once "view/others.php";
    }


//    function getOther() {
//        if (isset($_GET["id"]) && isset($_GET["category_id"])) {
//            $other = Other::getOtherById($_GET["id"], $_GET["category_id"]);
//            echo json_encode($other, JSON_UNESCAPED_UNICODE);
//        }
//    }
}