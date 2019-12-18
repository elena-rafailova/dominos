<?php

echo "Hello, you are in the main page, ";
echo $_SESSION["logged_user"]["first_name"]."<br>";
?>

<a href="index.php?target=user&action=logout"><button>Logout</button></a>
<a href="View/editProfile.php"><button>Edit Profile</button></a>
