<?php
/* 
 * Log out user.
 */
session_start();

session_destroy(); // delete all session data for user.

$thankhtml = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<title>Logged-out !</title>

</head>

<body style = "background-color:MediumAquaMarine" >
<h2> You have logged out successfully.</h2>
<h4> Thank you. </h4>
<br><br>
<a href="../"> GO HOME </a>
</body>
</html>
HTML;

echo "$thankhtml";

?>
