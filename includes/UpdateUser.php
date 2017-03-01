<?php


session_start();

require_once "../LocalSettings.php";
require_once "Globals.php";


if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && $_SESSION['Username'] == 'admin' ) )
{
	echo "session id :".session_id()." ,You need to login as Admin to remove users. Please log in as/contact Admin.";
	die();
}

if( isset( $_POST['submit']) )
{
	$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $eorgDBname );

	if( $sqlConn->connect_errno ) 
	{
		echo "Server error.";
		die();
	}

	$updt = "UPDATE $loginDB SET $FName = \"".$_POST['flname']."\", $Desig = \"".$_POST['dgname']."\" WHERE $UName = \"".$_POST['name']."\"";

$stmt = $sqlConn->prepare($updt);


	if( $stmt->execute() )
	{
		print "Record updated successfully";
	}
	else
	{
		echo "Error updating record.";
		print "<br>Try again";
	}

}
else
{
	echo "Please enter details.";
	die();
}


?>i
