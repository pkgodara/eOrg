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

$html =<<<HTML

<!DOCTYPE html>
<html lang="en">
<head>
<title>Add User</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>


body {
    color:white;
    background-image: url("../image/image4.jpg");
     min-height: 500px;
    background-attachment: fixed;
    background-position: center;
   
    background-size: cover;
    background-repeat: no-repeat;
}

button
{
	cursor: pointer; font-size : 25px; height:auto; width:auto ;background-color:transparent;color:white ;
	border: 0.25px solid white;
}
</style>

</head>

<body ><br>
<button onclick="document.location.href='dashboard/User.php'">HOME</button>
<button onclick="document.location.href='application/LeaveAppl.php'">BACK</button>
<center><b><i><br><br><br>


HTML;
echo $html;


	$user = $_SESSION['Username'];
	
	$appln = $_POST['appln'];
	
	$appTy = str_replace('.','$',$appln);
	$appTy = str_replace(' ','_',$appTy);
	
	$type = str_replace(' ','_',$appln);

	require_once "../LocalSettings.php";
	require_once "Globals.php";
	
	// finding approvers and acceptors
	//
	
	// Connect to mysql
	//
	$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $eorgDBname );

	if( $sqlConn->connect_errno ) 
	{
		echo "Server error.";
		die();
	}	

	//generates application status
	//
	require "DetermineApplnPath.php";
	
	// create application table if not exists
	//
	$qry = "CREATE TABLE IF NOT EXISTS $appTy ($AppId BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, $AppDate VARCHAR(10) NOT NULL, ";
	
	// current server date
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
	//echo "Updating application for $user.  ";
	
	$userDB = str_replace('.','$',$user);
	$stmt = $sqlConn->prepare("INSERT INTO $userDB VALUES (?,?,?)");
	$stmt->bind_param('sss',$id,$type,$date);

	if( ! $stmt->execute() )
	{
		echo "Error updating your database. ";
		die();
	}

	// Add application id in receiver's database
	//
	$appr = explode(';',$status)[1];
	$appr = explode(',',$appr)[0];
	
	//echo "Sending application to $appr";
	
	$destDB = str_replace('.','$',$appr);
	$destDB = str_replace(' ','_',$destDB);
	$stmt = $sqlConn->prepare("INSERT INTO $destDB VALUES (?,?,?)");
	$stmt->bind_param('sss',$id,$appTy,$date);

	if( ! $stmt->execute() )
	{
		echo "Error sending application.";
		die();
	}
	




	echo "Application successfully generated.";
}

?>
