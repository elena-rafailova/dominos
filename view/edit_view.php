<?php
include_once 'header.php';
$user = json_decode($_SESSION['logged_user']);

?>

<div class="container text-center  mb-3" >
    <h3 class="font-weight-bold text-center text-uppercase">Edit profile</h3>
<form action="index.php?target=user&action=edit" method="post">
    <div id="password_match" class="alert alert-warning w-25 mx-auto">Passwords don't match.</div>
    <div id="password_entered" class="alert alert-warning w-25 mx-auto">You have to enter your current password first!</div>
        <div class="form-group col-md-3  mx-auto" >
            <div class="input-group" >
    <div class="form-group mx-auto">
    <label class="font-weight-bold">First name: * </label>
    <input type="text" id="first_name" class="form-control " name="first_name" value="<?=$user->first_name ?>"
           pattern="[a-zA-Z\u0400-\u04ff].{3,30}" title="First name should contain only letters, at least 3!" required>
    </div>
    <div class="form-group mx-auto">
    <label class="font-weight-bold">Last name: * </label>
    <input type="text" id="last_name" class="form-control" name="last_name"  value="<?=$user->last_name ?>"
           pattern="[a-zA-Z\u0400-\u04ff].{3,30}" title="Last name should contain only letters,at least 3!" required>
    </div>
    <div class="form-group mx-auto">
    <label class="font-weight-bold">Email: * </label>
    <input type="email" id="email" class="form-control" name="email"  value="<?=$user->email ?>" readonly>
    </div>
    <div class="form-group mx-auto">
    <label class="font-weight-bold">Current password:</label>
    <input type="password" id="password" class="form-control" name="password" placeholder="Enter password" >
    </div>
    <div class="form-group mx-auto">
    <label class="font-weight-bold">New password:</label>
    <input type="password" id="new_password" class="form-control" name="new_password" placeholder="Enter new password"
           pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*]).{8,20}"
           title="Password should be at least 8 characters -
                containing at least one lowercase, one uppercase letter, one digit
                and one special character.">
    </div>
    <div class="form-group mx-auto">
    <label class="font-weight-bold">Verify password:</label>
    <input type="password" id="verify_password" class="form-control" name="verify_password" placeholder="Verify password"
           title="Please enter the same password as above.">
    </div>
            </div>
            <div class="mx-auto" >
                <input type="submit" class="btn btn-primary " id="edit_button" name="edit" value="Edit" >
            </div>
        </div>
</form>
</div>
<script>
checkPasswords();
</script>
