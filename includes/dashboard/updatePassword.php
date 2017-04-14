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


if (! (isset($_POST['new']) && isset($_POST['cnfNew']) && isset($_POST['old']) ))
{
	echo "Sorry, there is some problem<br>";
	die();
}



$new = $_POST['new'];
$cnfNew = $_POST['cnfNew'];
$old = $_POST['old'];
$user = $_SESSION['Username'];

if ($new != $cnfNew)
{
	echo "<br>Sorry, password are not matching<br>";
	die ();
}

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
	echo "Sorry, problem in database<br>";
	die();
}
$result = $stmt->get_result();

$row = mysqli_fetch_row($result);

if( ! password_verify($old,$row[1]) ) //if password correct
{
	echo "Don't try to be over smart :P <br>";
	die();
}

$stmt->close();

$hash = password_hash( $new , PASSWORD_BCRYPT );

$stmt = $sqlConn->prepare ("UPDATE $loginDB SET  $UPasswd = \"$hash\" WHERE $UName = \"$user\"");

if ( !$stmt->execute ( ))
{
	echo "Sorry, proble in database<br>";
	die();
}

$stmt->close();

echo "<br><br>Successfully Updated.<br><br>";





?>
