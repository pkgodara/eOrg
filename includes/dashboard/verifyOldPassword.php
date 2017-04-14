<?php

/* 
 * to change the password of the user
 */

session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) ) )
{
	echo "To access this page you need to login. Please log in first.";
	die();
}


if (! isset($_POST['prev']))
{
	echo "Sorry, there is some problem<br>";
	die();
}

$prev = $_POST['prev'];
$user = $_SESSION['Username'];

require_once "../../LocalSettings.php";
require_once "../Globals.php";



$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $eorgDBname );

if( $sqlConn->connect_errno ) 
{
	echo "Internal Server Error, Contact Administrator.";
	die();
}


$qry = "SELECT * FROM $loginDB WHERE $UName = \"$user\"" ;
$stmt = $sqlConn->prepare ( $qry );
if ( !$stmt->execute ( ))
{
	echo "Sorry, proble in database<br>";
	die();
}
$result = $stmt->get_result();

$row = mysqli_fetch_row($result);

if( password_verify($prev,$row[1]) ) //if password correct
{
	echo "1";
}
else
{
	echo "0";
}

$stmt->close();

?>
