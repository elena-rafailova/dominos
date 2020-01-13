<?php
namespace controller;

class basecontroller {
    public function basefunc() {
        if (isset($_session["logged_user"])) {
            header("location: index.php?target=pizza&action=showall");
        } else {
            header("location: index.php?target=user&action=main");
        }
    }
}
