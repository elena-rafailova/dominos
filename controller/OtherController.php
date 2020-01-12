<?php


namespace controller;

use exceptions\BadRequestException;
use exceptions\NotFoundException;
use model\DAO\OtherDAO;

class OtherController
{
    function showOthers() {
        $otherDAO = new OtherDAO();
        $others = $otherDAO->getAll($_GET["category_id"]);
        if ($others === false) {
            throw new NotFoundException("You are trying to reach non-existing products!");
        }
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
            throw new BadRequestException("The products you search for cannot be found!");
        }

        echo json_encode($others, JSON_UNESCAPED_UNICODE);
    }

}