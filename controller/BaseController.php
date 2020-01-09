<?php
namespace controller;

class BaseController {
    public function baseFunc() {
        if (isset($_SESSION["logged_user"])) {
            header("Location: index.php?target=pizza&action=showAll");
        } else {
            header("Location: index.php?target=user&action=login");
        }
    }
}
