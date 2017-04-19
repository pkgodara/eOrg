<?php

/* 
 * dashboard for admin
 */
session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && $_SESSION['Username'] === 'admin' ) )
{
	echo "To access this page you need to login as Admin. Please log in first.";
	die();
}


// Connect to DB
//
$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $eorgDBname );

if( $sqlConn->connect_errno ) 
{
	echo "Error connecting database. Please check your database credentials and update.";
	die();
}


// admin settings table

$query = "CREATE TABLE IF NOT EXISTS $settings ( $setKey VARCHAR(255) NOT NULL, $setValue VARCHAR(10) NOT NULL, INDEX idx USING BTREE ($setKey) )";

$stmt = $sqlConn->prepare( $query );


if ( ! $stmt->execute() ) // if unsuccessful
{
	echo "Error creating settings database.";
	die();
}
$stmt->close();



// initial settings : default
//
// Store credentials in DB
//
$query = "Insert INTO $settings VALUES ( \"Time before users can forward applications in days\" , \"0\" )";
$stmt = $sqlConn->prepare( $query );

if( ! $stmt->execute() )
{
	echo "Error updating settings information";
}

$stmt->close();
$sqlConn->close();


?>
