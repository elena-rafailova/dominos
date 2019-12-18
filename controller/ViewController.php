<?php
namespace Controller;

class ViewController {
    public function viewRouter($view) {
        if (!isset($_SESSION["logged_user"])){
            header("Location: view/login.php");
        }else{
            header("Location: view/$view.php");
        }
    }
}