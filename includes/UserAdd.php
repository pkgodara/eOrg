<?php

/* 
 * AddUser.php posts data here.
 * backend for adding user.
 *
 */

session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && ( $_SESSION['Username'] == 'admin' || isset($_SESSION['PostName']) ) ) )
{
	echo "session id :".session_id()." ,You need to login as Admin to add users. Please log in as/contact Admin.";
	die();
}



$html1 = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="shortcut icon" href="/favicon.png" type="image/png">
<link rel="shortcut icon" type="image/png" href="../image/gogreen.jpg" />
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
	cursor: pointer; font-size : 25px; height:auto; width:auto ;background-color:#000000;color:white ;
	border: 0.25px solid white;
}
</style>
<title>Admin</title>

</head>

<body><br><br>

HTML;
echo"$html1";

if ( $_SESSION['Username'] == 'admin')
{
echo "<button onclick=\"document.location.href='../' \"> HOME </button> ";
}
else
{
echo "<button onclick=\"document.location.href='dashboard/PostDashBoard.php'\"> HOME </button>";
}

$html = <<<HTML
<button onclick="document.location.href='AddUser.php'"> Add Another User </button>
<center>
HTML;

echo $html;

if( isset($_POST['user']) && isset($_POST['passwd']) && isset($_POST['fname']) && isset($_POST['LastValue'])  && isset($_POST['sex']) )
{


	require_once "../LocalSettings.php";
	require_once "Globals.php";
	require_once "StringManuplation.php";	
	
	$String = $_POST['LastValue'];
	
	$design = StringManuplation( $String );//finding final designation name



	$user = $_POST['user'];


	// Validate username : only A-Z and a-z and 0-9 and . is allowed.
	if( ! preg_match('#^[A-Za-z0-9\.]+$#' , $user ) )
	{
		echo "Username not allowed";
		die();
	}

	// SQL DB connection
	//
	$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $eorgDBname );

	if( $sqlConn->connect_errno ) 
	{
		echo "Server error.";
		die();
	}

	$hash = password_hash( $_POST['passwd'] , PASSWORD_BCRYPT );
	
	$flag = 0;


	// insert login data into database
	//
	$stmt = $sqlConn->prepare("Insert INTO $loginDB VALUES ( ?,?,?,?,? )" );
	$stmt->bind_param('sssss',$_POST['user'],$hash,$_POST['fname'],$_POST['sex'],$design );

	if( ! $stmt->execute() )
	{
		echo "<h1 style ='color:red'>Error updating database information, Try another username because same user name already exists</h1>";
		die();
	}
	
	else
	{
		$flag = 1 ;
	}
	

	$stmt->close();


	// update designation tree in Database;
	//
	$posts = explode(';',$design);
	
	// update record for each designation.
	//
	foreach( $posts as $post )
	{
		$stmt = $sqlConn->prepare("INSERT INTO $DesigDB VALUES (?,?)");
		$stmt->bind_param('ss', $post , $user );

		if( ! $stmt->execute() )
		{
			echo "Error updating designations.";
			die();
		}
	}


	// creating user database for storing owned applications
	// Since '.' is not allowed in name , using '$'
	//
	$userdb = str_replace('.','$',$user) ;
	
	$stmt = $sqlConn->prepare("CREATE TABLE $userdb ( $UserAppId BIGINT UNSIGNED NOT NULL, $UserAppTy VARCHAR(255), $AppDate VARCHAR(10) NOT NULL, INDEX idx USING BTREE($UserAppId), INDEX idx1 USING BTREE($UserAppTy) , INDEX idx2 USING BTREE($AppDate) )" );

	if( ! $stmt->execute() )
	{
		
		if($flag == 1)
	{
		echo "User Successfully created. ";
		die();
	}	
	else
	{
		echo "Error creating database for user, contact Admin ";
		die();
	}
	}
	$sqlConn->close();
	
	// create separate database to count applications.
	//
	$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , "" );

	if( $mysqlConn->connect_errno )  //if connection failed
	{
		echo "Sql credentials does not seem correct.<br>" ;
		die();
	}

	//create database if not exists
	//
	$stmt = $sqlConn->prepare( "create database if not exists $applnCount" );

	if( ! $stmt->execute() )
	{
		echo "Error creating database.";
		die();
	}

	$sqlConn->close();
	
	// create separate table to count applications.
	//
	$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $applnCount );
	$stmt = $sqlConn->prepare("CREATE TABLE  IF NOT EXISTS  $userdb ( $applnTy VARCHAR(255), $count BIGINT UNSIGNED NOT NULL, $tillDate VARCHAR(10),INDEX idx1 USING BTREE($applnTy), INDEX idx2 USING BTREE($tillDate) )" );

	if( ! $stmt->execute() )
	{
		echo "Error in creating count database for user, contact Admin.";
		die();
	}
	
	$sqlConn->close();

	echo "<h2>User Added Successfully.";
	die();
}
else
{
	echo "Please fill the details first.";
	die();
}

?>
