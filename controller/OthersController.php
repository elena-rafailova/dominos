<?php


namespace controller;

use model\Others;

class OthersController
{
    function showOthers() {
        if (!isset($_GET["filter"]) && isset($_GET["category_id"])) {
            $category_id = $_GET["category_id"];
            $others = Others::getAll($category_id);
        } elseif(isset($_GET["filter"]) && isset($_GET["category_id"]) ) {
            $category_id = $_GET["category_id"];
            $filter = $_GET["filter"];
            $others = Others::getAll($category_id,$filter);
        }
        include_once "view/others.php";
    }
}