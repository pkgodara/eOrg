<?php
/*
 *
 *  to forward application to specified acceptor.
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
	echo "Sorry, there was a problem, post data<br>";
	die();
}
else
{
	$app_id = $_POST['app_id'];
	$app_type = $_POST['app_type'];
	$next = $_POST['nextUser'];
	$UID ;
	
	if( isset( $_SESSION['PostName'] ) )
	{
		$UID = $_SESSION['PostName'];
		if ( forwardAcceptor($app_id, $app_type, $UID, $next) == true )
		{
			echo "The application has been successfully FORWARDED to $next<br>";
		}
		else
		{
			echo "Sorry, there was a problem updating<br>";
			die();
		}
	}
	else
	{
		$UID = $_SESSION['Username'];
		
		$status = $_POST['status'];
		
		$User = findPending($status);
		
		if( $User == null )
		{
			echo "Error forwarding";
			die();
		}
		else if ( forwardAcceptor($app_id, $app_type, $User, $next) == true )
		{
			echo "The application has been successfully FORWARDED to $next<br>";
		}
		else
		{
			echo "Sorry, there was a problem updating<br>";
			die();
		}
	}
}



echo "</body></html>";

?>
