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

<body >
<h3> You have logged out successfully.</h3>
<h4> Thank you. </h4>
</body>
</html>
HTML;

echo "$thankhtml";

?>
