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
<meta name="viewport" content="width=device-width, initial-scale=2.0">
<style>

a:link    {color:black;  text-decoration:none}/*link color when not visited anytime*/
a:visited {color:white;  text-decoration:none}/*link coloe after visiting*/
a:hover   {color:red;  text-decoration:none}/*link color when try to click the link*/
a:active  {color:white; background-color:transparent; text-decoration:none}/*link color juat after clicking if active*/


body {
    text-align:center;
    background-image: url("../stones.jpg");
    min-height: 500px;
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}
</style>
<title>Logged-out !</title>

</head>

<body >
HTML;
echo "$thankhtml";

include 'dashboard/Watch.php';

$thankhtml = <<<HTML

<h2 style = "color:white"> You have logged out successfully.</h2>
<h4 style = "color:white"> Thank you. </h4>
<br><br>
<div style = 'font-size:30px'>
<a href="../"> <h1 ><b><i>Login</i></b></h1> </a>
</div>
</body>
</html>
HTML;

echo "$thankhtml";

?>
