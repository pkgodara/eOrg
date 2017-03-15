<?php
/*
 *
 * this is to categories the users while initislizing the database during its installation.
 *
 */

session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && $_SESSION['Username'] === 'admin' ) )
{
	echo "To access this page you need to login as Admin. Please log in first.";
	die();
}



require_once "../../LocalSettings.php";
require_once "../Globals.php";



$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd  );

if( $sqlConn->connect_errno ) 
{
	echo "Error connecting database. Please check your database credentials and update.";
	die();
}


$stmt = $sqlConn->prepare( "create database if not exists $catDB" );

if( ! $stmt->execute() )
{
	echo "Error creating database.";
	die();
}

$stmt->close();
$sqlConn->close();



echo " Now, this is to generate the user categories using which you will create the users.<br><br><br>";

$html = <<<HTML
<html>
<head>
<title>Categorise Users</title>
</head>
<body>
<p>
Please click <a href="broadCatUsers.php">here</a> to broadly categorise the USERS...
</p>
</body>
</html>
HTML;


echo $html;











?>
