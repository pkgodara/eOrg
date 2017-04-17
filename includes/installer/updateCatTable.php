<?php
/*
 *
 * This is to update the categories table.
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


if ( !(isset($_POST['tab']) && isset($_POST['levelId']) && isset($_POST['catType']) ) )
{
	echo "Sorry, there is some problem<br>";
	die ();
}



$tab = $_POST['tab'];
$levId = $_POST['levelId'];
$catType = $_POST['catType'];
$catId = str_replace ( "L", "C", $levId );
$newLevId = $levId."_";
$lev = array();
$lev = $_POST['levels'];

$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $catDB );

if( $sqlConn->connect_errno ) 
{
	echo "Error connecting database. Please check your database credentials and update.";
	die();
}

$stmt = $sqlConn->prepare ( "INSERT INTO $tab VALUES (?,?)" );
$stmt->bind_param('ss',$catId, $catType );


if ( ! $stmt->execute() ) // if unsuccessful
{
echo "Error in database.";
die();
}

$stmt->close();

for ( $i = 0 ; $i < count ( $lev ) ; $i++ )
{
	$query = "INSERT INTO $tab VALUES (?, ?)";

	$stmt = $sqlConn->prepare( $query );
	$temp = $levId."_".($i+1);
	$stmt->bind_param ('ss',$temp, $lev[$i] );


	if ( ! $stmt->execute() ) // if unsuccessful
	{
		echo "Error in database.";
		die();
	}

	$stmt->close();

}

$sqlConn->close();

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
echo "Updated successfully<br>";
echo "for further categorisation please click <a href='addNewCat.php'>here</a><br>";
echo "<br><a href='../../'>GO HOME</a><br>";

?>
