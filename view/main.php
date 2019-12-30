<?php

echo " Hello, you are in the main page, ";
$user = json_decode($_SESSION['logged_user']);
echo $user->first_name."<br>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Main</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
<a href="index.php?target=pizza&action=showAll"><button>Menu</button></a>
<a href="index.php?target=restaurant&action=show"><button>Restaurants</button></a>
<ul id="buttons">
    <li><a href="index.php?view=edit"><button>My Profile (edit) </button></a></li>
    <li><a href="index.php?target=address&action=show"><button>My Addresses</button></a></li>
    <li><a href="index.php?target=user&action=logout"><button>Logout</button></a></li>
</ul>
<br><br>
</body>
</html>



