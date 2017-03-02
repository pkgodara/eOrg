<?php
/*
 *
 *  to approve application by the approver.
 */

session_start();

if ( !( isset( $_SESSION['Username'] ) && isset( $_SESSION['Name'] ) ) )
{
	echo "session id :".session_id()." ,You must login first to visit this page.";
	die();
}


require "ApplHandlingByID.php";
require "ApplHandlingByStr.php";
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
	$UID = $_SESSION['Username'];
	if ( isApprover ( $app_id, $UID ) )
	{
		approve ( $app_id, $UID );
		echo "The application has been successfully approved<br>";
	}
	else
	{
		echo "Sorry, there was a problem<br>";
		die();
	}
}




?>
