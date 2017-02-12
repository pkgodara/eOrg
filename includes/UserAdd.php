<?php

/* 
 * backend for adding user.
 */

if( isset($_POST['user']) && isset($_POST['passwd']) && isset($_POST['fname']) && isset($_POST['design']) )
{
	require_once "../LocalSettings.php";
	require_once "Globals.php";

	$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $eorgDBname );

	if( $sqlConn->connect_errno ) 
	{
		echo "Server error.";
		die();
	}

	$hash = password_hash( $_POST['passwd'] , PASSWORD_BCRYPT );

	$stmt = $sqlConn->prepare("Insert INTO $loginDB VALUES ( ?,?,?,? )" );
	$stmt->bind_param('ssss',$_POST['user'],$hash,$_POST['fname'],$_POST['design'] );

	if( ! $stmt->execute() )
	{
		echo "Error updating database information";
	}

	$stmt->close();
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
