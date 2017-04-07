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
<style>
body {
text-align:center;
    background-image: url("../stones.jpg");
}
</style>
<title>Logged-out !</title>

</head>

<body >
<h2> You have logged out successfully.</h2>
<h4> Thank you. </h4>
<br><br>
<a href="../"> <h1>Login</h1> </a>
</body>
</html>
HTML;

echo "$thankhtml";

?>
