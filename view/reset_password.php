<?php
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset your password</title>
</head>
<body>
<form action="index.php?target=user&action=changePassword" method="post">
    <label>New Password:</label><br>
    <input type="password" name="new_password" placeholder="Enter password" required><br>
    <label>Confirm Password:</label><br>
    <input type="password" name="confirm_password" placeholder="Confirm password" required><br>
    <input type="submit" name="change_password" value="Reset my password" ><br>
</form>
</body>
</html>
