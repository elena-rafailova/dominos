<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <form action="index.php?target=user&action=login" method="post">
        <label>Email:</label><br>
        <input type="email" name="email" placeholder="Enter email" required><br>
        <label>Password:</label><br>
        <input type="password" name="password" placeholder="Enter password" required><br>
        <input type="submit" name="login" value="Login" ><br>
    </form>
</body>
</html>
