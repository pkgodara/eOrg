<?php
/*
 *
 *  to approve application by the approver.
 */

session_start();

if ( !( isset( $_SESSION['Username'] ) && isset( $_SESSION['Name'] ) && isset( $_SESSION['PostName'] ) ) )
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
	$UID = $_SESSION['PostName'];
	
	if ( isApprover ( $app_id, $app_type , $UID ) != false )
	{
		approve( $app_id, $app_type , $UID );
		echo "The application has been successfully approved<br>";
	}
	else
	{
		echo "Sorry, there was a problem<br>";
		die();
	}
}



echo "</body></html>";

?>
