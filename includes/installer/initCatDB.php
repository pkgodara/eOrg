<?php
/*
 *
 * This is to initialize the category user database
 *
 */


session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && $_SESSION['Username'] === 'admin' ) )
{
	echo "To access this page you need to login as Admin. Please log in first.";
	die();
}


if ( ! isset ( $_POST['submit'] ) )
{
	echo "Sorry, there is some problem with it<br>";
	die ();
}

require_once "../../LocalSettings.php";
require_once "../Globals.php";


$lev = array ();
$lev = $_POST['levels'];


$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $catDB );


if( $sqlConn->connect_errno ) 
{
	echo "Error connecting database. Please check your database credentials and update.";
	die();
}


for ( $i = 0 ; $i < count ( $lev ) ; $i++ )
{
	$query = "CREATE TABLE IF NOT EXISTS $lev[$i] ( $levels VARCHAR(200) NOT NULL, $levelName VARCHAR(50) NOT NULL, INDEX idx USING BTREE ($levels) )";

	$stmt = $sqlConn->prepare( $query );


	if ( ! $stmt->execute() ) // if unsuccessful
	{
		echo "Error in database.";
		die();
	}

	$stmt->close();


	$val = "L".($i+1);
	$stmt = $sqlConn->prepare("INSERT INTO $lev[$i] VALUES (?,?)");
	$stmt->bind_param('ss', $val , $lev[$i] );


	if( ! $stmt->execute() )
	{
		echo "Error in database.";
		die();
	}
	
	$stmt->close();
	
}

echo "The entered broad categories has been updated in the database successfully<br>";

echo "for further categorisation please click <a href='furtherCatBroad.php'>here</a><br>"






?>
