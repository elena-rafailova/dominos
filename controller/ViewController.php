<?php
namespace Controller;

class ViewController {
    public function viewRouter($view) {

        include_once "view/$view.php";
    }
}