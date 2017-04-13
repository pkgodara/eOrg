<?php
/*
 *
 * This is to provide further branches to the delete option
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


if ( !(isset($_POST['tab']) && isset($_POST['levelId'])) )
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

$newLevId = $levId."_[0-9]{1,}";
$qry = "SELECT * FROM $tab WHERE $levels REGEXP \"^$newLevId$\"";
$stmt = $sqlConn->prepare($qry);

if ( ! $stmt->execute() )
{
	echo"there is a problem with database<br>";
	die ();
}

$result = $stmt->get_result ();



if ( $result->num_rows == 0 )
{
	echo "No further branches are available, now, done it.";
}
else
{
	$qry2 = "SELECT * FROM $tab WHERE $levels REGEXP \"^$catType$\"";
	$stmt2 = $sqlConn->prepare($qry2);
	if ( ! $stmt2->execute() )
	{
		echo"there is a problem with database<br>";
		die ();
	}
	$res2 = $stmt2->get_result();
	if ( $res2->num_rows == 0 )
	{
		echo "Sorry there is some problem<br>";
		die();
	}
	$row2 = mysqli_fetch_row ($res2);
	echo "<select name=$tab onchange='porvideButtons(this.name, this.value)' required>";
	echo "<option value=''>click to select the $row2[1]</option>";
	$stmt2->close();
	while ($row = mysqli_fetch_row ($result))
	{
		echo "<option value=$row[0]>$row[1]</option>";
	}
}

$stmt->close();


?>
