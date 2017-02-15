<?php
/*
 *  remove user details and all data if required from database.
 */

session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && $_SESSION['Username'] == 'admin' ) )
{
	echo "session id :".session_id()." ,You need to login as Admin to remove users. Please log in as/contact Admin.";
	die();
}

if( isset( $_POST['user'] ) )
{
	require_once "../LocalSettings.php";
	require_once "Globals.php";
	
	$userN = $_POST['user'] ;
	$sqlConn = new mysqli ( $eorgDBserver, $eorgDBuser, $eorgDBpasswd, $eorgDBname );
	if ( $sqlConn->connect_errno )
	{
		echo "Server Error.";
		die ();
	}

$qry = "DELETE FROM $loginDB WHERE $UName = ?" ;
	$stmt = $sqlConn->prepare ( $qry );
	$stmt->bind_param ( 's', $userN );
	if ( ! $stmt->execute() )
	{
		echo "The user $userN doesnot exists ";
		die();
	}
	else
	{
		echo "The user $userN has been successfully deleted";
	}
	$stmt->close();

	if( isset( $_POST['removeData'] ) ) // remove all data for user
	{
		$user = str_replace('.','$',$userN);
		$stmt = $sqlConn->prepare ( "DROP TABLE $user");
		if ( ! $stmt->execute() )
		{
			echo "The table of user $userN doesnot exists.";
			die ();
		}
		else
		{
			echo "And the complete data of user $userN is successfully deleted also.";
		}
		$stmt->close();
	}
	$sqlConn->close();
}
else
{
	echo "Please fill the details first.";
	die();
}


?>
