<?php
/*
 *
 *  to accept application by the accepter.
 */

session_start();

if ( !( isset( $_SESSION['Username'] ) && isset( $_SESSION['Name'] ) ) )
{
	echo "session id :".session_id()." ,You must login first to visit this page.";
	die();
}


require "../ApplHandlingByID.php";
require "../ApplHandlingByStr.php";

//require_once "Globals.php";
//require_once "../LocalSettings.php";


if ( ! isset (  $_POST['app_id'] ) )
{
	echo "Sorry, there was a problem.<br>";
	die();
}
else
{
	$app_id = $_POST['app_id'];
	$app_type = $_POST['app_type'];
	$UID = $_SESSION['Username'];
	
	if ( isAccepter ( $app_id, $app_type , $UID ) != false )
	{
		accept ( $app_id, $app_type , $UID );
		echo "The application has been successfully accepted<br>";
	}
	else
	{
		echo "Sorry, there was a problem<br>";
		die();
	}
}




?>
