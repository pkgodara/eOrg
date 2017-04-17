<?php
/*
 *
 *  to forward application if not processed in certain days.
 */

session_start();

if ( !( isset( $_SESSION['Username'] ) && isset( $_SESSION['Name'] ) ) )
{
	echo "session id :".session_id()." ,You must login first to visit this page.";
	die();
}


require "../ApplHandlingByID.php";
require "../ApplHandlingByStr.php";

$html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="/favicon.png" type="image/png">
<link rel="shortcut icon" type="image/png" href="../../image/gogreen.jpg" />
<style>
body {
    
    background-image: url("../../image/image4.jpg");
     min-height: 500px;
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}
button
{
	cursor: pointer; font-size : 25px; height:auto; width:auto ;background-color:transparent;color:white ;
	border: 0.25px solid white;
}
</style>
</head>

<body style = "color:white">
<button onclick="document.location.href='handleAppl.php'"> BACK </button>
<center><b><i>
HTML;
echo $html;



if ( ! isset (  $_POST['app_id'] ) )
{
	echo "Sorry, there was a problem.<br>";
	die();
}
else
{
	$app_id = $_POST['app_id'];
	$app_type = $_POST['app_type'];
	$status = $_POST['status'];
	 
	
	if( needApprover($status) )
	{
		echo <<<HTML
<form action="forwardApprover.php" method="post">
<input type="text" name="app_id" value=$app_id style="visibility: hidden; display: none;" readonly>
<input type="text" name="app_type" value=$app_type style="visibility: hidden; display: none;" readonly>
<input type="submit" value="Forward to Next Person"><br><br><br>
</form>
HTML;
	}
	else if( needAcceptor($status) )
	{
		echo <<<HTML

<br><br>
<form action="forwardAcceptor.php" method="post">
<input type="text" name="app_id" value=$app_id style="visibility: hidden; display: none;" readonly>
<input type="text" name="app_type" value=$app_type style="visibility: hidden; display: none;" readonly>
Forward To : <input type="text" name="nextUser" > <br>
<input type="submit" value="Forward">
</form>
HTML;
	}
	
}



echo "</body></html>";

?>
