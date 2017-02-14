<?php

/* 
 * backend for adding user.
 */

if( isset($_POST['user']) && isset($_POST['passwd']) && isset($_POST['fname']) && isset($_POST['design']) )
{
	require_once "../LocalSettings.php";
	require_once "Globals.php";

	$user = $_POST['user'];

	if( ! preg_match('/[A-Za-z0-9.]/' , $user ) )
	{
		echo "Username not allowed";
		die();
	}

	$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $eorgDBname );

	if( $sqlConn->connect_errno ) 
	{
		echo "Server error.";
		die();
	}

	$hash = password_hash( $_POST['passwd'] , PASSWORD_BCRYPT );

	// insert login data into database
	//
	$stmt = $sqlConn->prepare("Insert INTO $loginDB VALUES ( ?,?,?,? )" );
	$stmt->bind_param('ssss',$_POST['user'],$hash,$_POST['fname'],$_POST['design'] );

	if( ! $stmt->execute() )
	{
		echo "Error updating database information, Try another username";
		die();
	}

	$stmt->close();

	// creating user database for storing owned applications
	// Since . is not allowed in name , using $
	$userdb = str_replace('.','$',$user) ;
	$stmt = $sqlConn->prepare("CREATE TABLE $userdb ( $UserAppId BIGINT UNSIGNED NOT NULL, $UserAppTy VARCHAR(5), PRIMARY KEY($UserAppId) )" );

	if( ! $stmt->execute() )
	{
		//echo "Error : $sqlConn->errno : $sqlConn->error <br>";
		echo "Error creating database for user, contact Admin";
		die();
	}

	$sqlConn->close();

	echo "user added successfully";
	die();
}
else
{
	echo "Please fill the details first.";
	die();
}

?>
