<?php
include_once 'header.php';
$user = json_decode($_SESSION['logged_user']);
?>
<div class="container text-center" >
<form action="index.php?target=user&action=edit" method="post">
    <div class="form-row">
        <div class="form-group col-md-3 mx-auto">
            <div class="input-group mb-3">
    <div class="form-group">
    <label class="font-weight-bold">First name: * </label><br>
    <input type="text" class="form-control " name="first_name" value="<?= $user->first_name ?>" required><br>
    </div>
    <div class="form-group">
    <label class="font-weight-bold">Last name: * </label><br>
    <input type="text" class="form-control" name="last_name"  value="<?= $user->last_name ?>" required><br>
    </div>
    <div class="form-group">
    <label class="font-weight-bold">Email: * </label><br>
    <input type="email" class="form-control" name="email"  value="<?= $user->email ?>" readonly><br>
    </div>
    <div class="form-group">
    <label class="font-weight-bold">Current password:</label><br>
    <input type="password" class="form-control" name="password" placeholder="Enter password" ><br>
    </div>
    <div class="form-group">
    <label class="font-weight-bold">New password:</label><br>
    <input type="password" class="form-control" name="new_password" placeholder="Enter new password" ><br>
    </div>
    <div class="form-group">
    <label class="font-weight-bold">Verify password:</label><br>
    <input type="password" class="form-control" name="verify_password" placeholder="Verify password" ><br>
    </div>
    <div class="input-group">
        <input type="submit" class="btn btn-primary " name="edit" value="Edit" ><br>
    </div>
            </div>
        </div>
    </div>
</form>
</div>
