<?php
/*
 *
 * This is to delete a categoty from database
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


if ( !(isset($_POST['tab']) && isset($_POST['levelId']) && isset($_POST['submit']) ) )
{
	echo "Sorry, there is some problem<br>";
	die ();
}



$tab = $_POST['tab'];
$levId = $_POST['levelId'];
$catType = str_replace ( "L", "C", $levId );


$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $catDB );

if( $sqlConn->connect_errno ) 
{
	echo "Error connecting database. Please check your database credentials and update.";
	die();
}

$stmt = $sqlConn->prepare("SELECT * FROM $tab LIMIT 1");

if ( ! $stmt->execute () )
{
	echo "Sorry problem with database<br>";
	die ();
}
$res = $stmt->get_result ();
$row = mysqli_fetch_row ( $res );


if ($row[0] == $levId)
{
	$stmt2 = $sqlConn->prepare("DROP TABLE $tab");
	if ( ! $stmt2->execute () )
	{
		echo "Sorry problem with database<br>";
		die ();
	}
	$stmt2->close();
}
else
{
	$stmt2 = $sqlConn->prepare("DELETE FROM $tab WHERE $levels REGEXP \"^$levId\"");
	if ( ! $stmt2->execute () )
	{
		echo "Sorry problem with database<br>";
		die ();
	}

	$stmt3 = $sqlConn->prepare("DELETE FROM $tab WHERE $levels REGEXP \"^$catType\"");
	if ( ! $stmt3->execute () )
	{
		echo "Sorry problem with database<br>";
		die ();
	}
	
	$stmt2->close();
	$stmt3->close();

}

$stmt->close();

$html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="/favicon.png" type="image/png">
<link rel="shortcut icon" type="image/png" href="../../image/gogreen.jpg" />
<style>
a:link    {color:red;  text-decoration:none}/*link color when not visited anytime*/
a:visited {color:red;  text-decoration:none}/*link coloe after visiting*/
a:hover   {color:white;  text-decoration:none}/*link color when try to click the link*/
a:active  {color:red; background-color:transparent; text-decoration:none}/*link color juat after clicking if active*/

body {
	
    font-size:30px;
    color:white;
    background-image: url("../../image/image4.jpg");
     min-height: 500px;
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}
</style>
</head>

<body>
<center><b><i><br><br><br><br><br><br>
HTML;


echo $html;

echo "Succesfully deleted<br><br>";

echo "<a href='deleteCat.php'>DELETE ANOTHER</a><br>";
echo "<a href='../../'>HOME</a><br>";

?>
