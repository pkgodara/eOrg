<?php

/* 
 * generate and initiate processing for application.
 *
 */

session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) ) )
{
	echo "You need to login to generate leave applications. Please log in.";
	die();
}

if( !isset( $_POST['appln'] ) )
{
	echo "Credentials not filled.";
	die();
}
else
{
	$user = $_SESSION['Username'];
	
	$appln = $_POST['appln'];
	
	$appTy = str_replace('.','$',$appln);
	
	$type = str_replace('_',' ',$appln);

	require_once "../LocalSettings.php";
	require_once "Globals.php";
	
	// finding approvers and acceptors
	//
	$appr = 'user2';
	$dest = 'user3';
	
	$status = $user.",G;".$appr.",P;"."$dest,P" ; // initial status for application.

	// Connect to mysql
	//
	$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $eorgDBname );

	if( $sqlConn->connect_errno ) 
	{
		echo "Server error.";
		die();
	}
	
	// create application table if not exists
	//
	$qry = "CREATE TABLE IF NOT EXISTS $appTy ($AppId BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, $AppDate VARCHAR(10) NOT NULL, ";
	$date = date('Y-m-d');
	$qry1 = "Insert INTO $appTy VALUES (NULL,\"$date\",";
	
	foreach( $_POST as $key => $value )
	{	
		if( $key == "appln" || $key == "submit" )
			continue;
		if( $key == "Start_Date" || $key == "End_Date" )
		{
			$qry = $qry."$key VARCHAR(10) NOT NULL," ;
		}
		else
		{
			$qry = $qry."$key VARCHAR(255) NOT NULL,";
		}
		
		$qry1 = $qry1."\"$value\",";
	}
	
	$qry = $qry." $stat VARCHAR(255) NOT NULL , PRIMARY KEY($AppId) , INDEX idx USING BTREE($AppDate) )";
	$qry1 = $qry1."\"$status\")";
	
	$stmt = $sqlConn->prepare( $qry );
	
	if( !$stmt->execute() )
	{
		echo "error creating application database.";
	}
	
	
	// Insert application data into application database
	//
	$stmt = $sqlConn->prepare($qry1);
	
	if ( !$stmt->execute() )
	{
		echo "Error generating application.";
		die();
	}
	
	$id = $stmt->insert_id ;  // auto incremented application id .

	// Add Application id in sender's database
	//
	$userDB = str_replace('.','$',$user);
	$stmt = $sqlConn->prepare("INSERT INTO $userDB VALUES (?,?)");
	$stmt->bind_param('ss',$id,$type);

	if( ! $stmt->execute() )
	{
		echo "Error updating your database.";
		die();
	}

	// Add application id in receiver's database
	//
	$destDB = str_replace('.','$',$appr);
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
