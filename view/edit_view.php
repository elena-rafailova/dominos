<?php
include_once 'header.php';
$user = json_decode($_SESSION['logged_user']);
?>

<div class="container text-center  mb-3" >
    <h3 class="font-weight-bold text-center text-uppercase">Edit profile</h3>
<form action="index.php?target=user&action=edit" method="post">
        <div class="form-group col-md-3  mx-auto" >
            <div class="input-group" >
    <div class="form-group mx-auto">
    <label class="font-weight-bold">First name: * </label>
    <input type="text" class="form-control " name="first_name" value="<?= $user->first_name ?>" required>
    </div>
    <div class="form-group mx-auto">
    <label class="font-weight-bold">Last name: * </label>
    <input type="text" class="form-control" name="last_name"  value="<?= $user->last_name ?>" required>
    </div>
    <div class="form-group mx-auto">
    <label class="font-weight-bold">Email: * </label>
    <input type="email" class="form-control" name="email"  value="<?= $user->email ?>" readonly>
    </div>
    <div class="form-group mx-auto">
    <label class="font-weight-bold">Current password:</label>
    <input type="password" class="form-control" name="password" placeholder="Enter password" >
    </div>
    <div class="form-group mx-auto">
    <label class="font-weight-bold">New password:</label>
    <input type="password" class="form-control" name="new_password" placeholder="Enter new password" >
    </div>
    <div class="form-group mx-auto">
    <label class="font-weight-bold">Verify password:</label>
    <input type="password" class="form-control" name="verify_password" placeholder="Verify password" >
    </div>
            </div>
            <div class="mx-auto" >
                <input type="submit" class="btn btn-primary " name="edit" value="Edit" >
            </div>
        </div>
</form>
</div>
