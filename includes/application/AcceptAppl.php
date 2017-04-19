<?php
/*
 *
 *  to accept application by the accepter.
 */

session_start();

if ( !( isset( $_SESSION['Username'] ) && isset( $_SESSION['Name'] ) && isset( $_SESSION['PostName'] ) ) )
{
	echo "session id :".session_id()." ,You must login first to visit this page.";
	die();
}

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


require "../ApplHandlingByID.php";
require "../ApplHandlingByStr.php";

require_once "../Globals.php";
require_once "../../LocalSettings.php";
require_once "countApplications.php";
require_once "modifyApplnCount.php";


if ( ! isset (  $_POST['app_id'] ) )
{
	echo "Sorry, there was a problem.<br>";
	die();
}
else
{
	$id = $_POST['app_id'];
	$type = $_POST['app_type'];
	$UID = $_SESSION['PostName'];

	if ( isAccepter ( $id, $type , $UID ) != false )
	{
		accept ( $id, $type , $UID );

		// update count of applications for user.
		$sqlconn = new mysqli ( $eorgDBserver, $eorgDBuser, $eorgDBpasswd, $eorgDBname );

		if ( $sqlconn->connect_errno )
		{
			echo "Internal Server Error, Sorry for inconvenience.";
			die();
		}

		$qry = "SELECT * FROM $type WHERE $AppId = ?";
		$stmt = $sqlconn->prepare ( $qry );

		$stmt->bind_param ( 's', $id );
		if ( ! $stmt->execute() )
		{
			echo "Sorry, there is a problem with database.";
			die();
		}
		else
		{
			$result = $stmt->get_result();
			$row = $result->fetch_array();

			$qr = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = \"$eorgDBname\" AND TABLE_NAME = \"$type\"";
			$cols = $sqlconn->query($qr);
			
			$flagD = false;
			$stD; //start date
			$enD;
			$count = 0;

			while( $res = mysqli_fetch_array( $cols ) )
			{
				if( $res[0] == 'Start_Date' )
				{
					$stD = $row[2];
					$flagD = true;
				}
				else if( $res[0] == 'End_Date' )
				{
					$enD = $row[3];
					$flagD = true;
					break;
				}
			}
			
			// get generator user
			$genr = explode( ',' , explode( ';', $row[ $stat ] )[0] )[0];
			$userdb = str_replace('.','$', $genr );

			// update count in database
			if( ! $flagD )
			{
				updateCount( $userdb , $type , $row[1] , '1' );
			}
			else
			{
				$days = ( strtotime($enD) - strtotime($stD) )/ (60*60*24) + 1;
				echo "days : $days";
				updateCount( $userdb , $type , $enD , $days );
			}

		}

		echo "The application has been successfully accepted<br>";
	}
	else
	{
		echo "Sorry, there was a problem<br>";
		die();
	}
}




?>
