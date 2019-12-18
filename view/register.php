<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
        <form action="../index.php?target=user&action=register" method="post">
            <label>First name:</label><br>
            <input type="text" name="first_name" placeholder="Enter first name" required><br>
            <label>Last name:</label><br>
            <input type="text" name="last_name" placeholder="Enter last name" required><br>
            <label>Email:</label><br>
            <input type="email" name="email" placeholder="Enter email" required><br>
            <label>New password:</label><br>
            <input type="password" name="password" placeholder="Enter password" required><br>
            <label>Verify password:</label><br>
            <input type="password"  name="verifyPass" placeholder="Verify password" required><br>
            <input type="submit" name="register" value="Register" ><br>
        </form>
</body>
</html>