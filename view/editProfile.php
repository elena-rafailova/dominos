<?php
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Profile</title>
</head>
<body>
<form action="../index.php?target=user&action=edit" method="post">
    <label>First name:</label><br>
    <input type="text" name="first_name" value="<?php $_SESSION['logged_user']['first_name']?>" required><br>
    <label>Last name:</label><br>
    <input type="text" name="last_name"  value="<?php $_SESSION['logged_user']['last_name']?>" required><br>
    <label>Email:</label><br>
    <input type="email" name="email"  value="<?php $_SESSION['logged_user']['email']?>" readonly><br>
    <label>Current password:</label><br>
    <input type="password" name="password" placeholder="Enter password" required><br>
    <label>New password:</label><br>
    <input type="password" name="password" placeholder="Enter new password" required><br>
    <label>Verify password:</label><br>
    <input type="password"  name="verifyPass" placeholder="Verify password" required><br>
    <input type="submit" name="edit" value="Edit" ><br>
</form>
</body>
</html>
