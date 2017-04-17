<?php
/*
 *
 * this is to modify the existing categories
 *
 */

session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && $_SESSION['Username'] === 'admin' ) )
{
	echo "To access this page you need to login as Admin. Please log in first.";
	die();
}


$html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="/favicon.png" type="image/png">
<link rel="shortcut icon" type="image/png" href="../image/gogreen.jpg" />
<style>
body {
    
    background-image: url("../image/image4.jpg");
     min-height: 500px;
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}
button
{
	cursor: pointer; font-size : 25px; height:auto; width:auto ;background-color:#000000;color:white ;
	border: 0.25px solid white;
}
</style>
</head>

<body>
<center>
<br><br><br><br><br><br><br><br>
<button onclick="document.location.href='../'" > HOME</button><br><br>
<form action="installer/addNewCat.php">
<button type="submit">Add a new category</button><br><br>
</form>
<form action="installer/deleteCat.php">
<button type="submit">Delete a category</button><br><br>
</form>
</center></body></html>
HTML;


echo $html;


?>
