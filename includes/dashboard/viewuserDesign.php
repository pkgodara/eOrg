<?php

/* 
 * this is to view the designation of a user
 */

session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && $_SESSION['Username'] === 'admin' ) )
{
	echo "To access this page you need to login as Admin. Please log in first.";
	die();
}

require_once "../../LocalSettings.php";
require_once "../Globals.php";


$_POST['desigId'] = "L_1;L_1_5;L_1_5_1;L_1_5_1_1";

if (!isset ($_POST['desigId']) )
{
	echo "Sorry, there is some proble<br>";
	die();
}

$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $catDB );

if( $sqlConn->connect_errno ) 
{
	echo "Internal Server Error, Contact Administrator.";
	die();
}


$desigArr = array();
$desigArr = explode (';', $_POST['desigId']);
$finalStr = "->";

$qry = "SELECT TABLE_NAME FROM information_schema.tables WHERE table_schema = ?";
$stmt = $sqlConn->prepare( $qry );
$stmt->bind_param ( 's', $catDB );


if ( ! $stmt->execute() )
{
	echo"there is a problem with database<br>";
	die ();
}

$res = $stmt->get_result();

if ( $res->num_rows == 0 )
{
	echo "Sorry, first set the broad categories<br>";
	die ();
}

while ($row = mysqli_fetch_row ($res))
{
	$newRow = str_replace('_', ' ', $row[0]);
	$qry2 = "SELECT * FROM $row[0] LIMIT 1"; // to take the level no. of the broad category
	$stmt2 = $sqlConn->prepare ( $qry2 );
	if ( ! $stmt2->execute () )
	{
		echo "Sorry problem with database<br>";
		die ();
	}
	$res2 = $stmt2->get_result ();
	$row2 = mysqli_fetch_row ( $res2 );	
	if ( $row2[0] == $desigArr[0] )
	{
		$tab = $row[0];
		$finalStr = $finalStr.$newRow."->";
		break;
	}
	$stmt2->close();
}

$stmt->close();

if (empty($tab))
{
	echo "Sorry, there is soem problem<br>";
	die();
}

for ($i = 1 ; $i < count($desigArr) ; $i++ )
{
	$stmt = $sqlConn->prepare ("SELECT * FROM $tab WHERE $levels REGEXP \"^$desigArr[$i]$\"");
	if ( ! $stmt->execute () )
	{
		echo "Sorry problem with database<br>";
		die ();
	}
	$res = $stmt->get_result ();
	if ($res->num_rows == 0)
	{
		echo "Sorry problem with database<br>";
		die ();
	}
	$row = mysqli_fetch_row ( $res );
	$finalStr = $finalStr.$row[1]."->";
	
	$stmt->close();
	
}

echo $finalStr;






?>
