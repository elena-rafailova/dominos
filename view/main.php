<?php

echo "Hello, you are in the main page, ";
echo $_SESSION["logged_user"]["first_name"]."<br>";
?>

<a href="index.php?target=user&action=logout"><button>Logout</button></a>
<a href="index.php?view=edit"><button>Edit Profile</button></a>
<a href="index.php?target=pizza&action=show"><button>Menu</button></a>

