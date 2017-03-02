<?php

/* 
 * generate and initiate processing for application.
 *
 */

session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) ) )
{
	echo "session id :".session_id()." ,You need to login to generate leave applications. Please log in.";
	die();
}

if( !(isset( $_POST['from'] ) && isset( $_POST['upto'] ) && isset( $_POST['reason'] ) ) )
{
	echo "Credentials not filled.";
	die();
}
else
{
	$user = $_SESSION['Username'];
	$from = $_POST['from'];
	$upto = $_POST['upto'];
	$reason = $_POST['reason'];
	$dest = $_POST['dest'];
	$appr = $_POST['appr'];
	$appTy = 'LA'; // leave application

	require_once "../LocalSettings.php";
	require_once "Globals.php";

	$status = $_SESSION['Username'].",G;".$appr.",P;"."$dest,P" ; // initial status for application.

	// Connect to mysql
	//
	$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $eorgDBname );

	if( $sqlConn->connect_errno ) 
	{
		echo "Server error.";
		die();
	}

	// Insert application data into application database
	//
	$stmt = $sqlConn->prepare("Insert INTO $AppDB VALUES (NULL,?,?,?,?,?)");
	$stmt->bind_param( 'sssss',$appTy ,$status ,$from ,$upto , $reason ) ;

	if ( ! $stmt->execute() )
	{
		echo "Error generating application.";
		die();
	}
	

	$id = $stmt->insert_id ;  // auto incremented application id .

	// Add Application id in sender's database
	//
	$userDB = str_replace('.','$',$user);
	$stmt = $sqlConn->prepare("INSERT INTO $userDB VALUES (?,?)");
	$stmt->bind_param('ss',$id,$appTy);

	if( ! $stmt->execute() )
	{
		echo "Error updating your database.";
		die();
	}

	// Add application id in receiver's database
	//
	$destDB = str_replace('.','$',$dest);
	$stmt = $sqlConn->prepare("INSERT INTO $destDB VALUES (?,?)");
	$stmt->bind_param('ss',$id,$appTy);

	if( ! $stmt->execute() )
	{
		echo "Error sending application.";
		die();
	}

	echo "Application successfully generated.";
}

?>
