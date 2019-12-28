
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>
<body>
    <p>Please enter your email so we can assist you in resetting your password.</p>
    <form action="index.php?target=user&action=forgotPassword" method="post">
        <label>Email:</label><br>
        <input type="email" name="email" placeholder="Enter email" required><br>
        <input type="submit" name="forgot_password" value="Send an email" ><br>
    </form>
</body>
</html>
