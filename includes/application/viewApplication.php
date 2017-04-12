<?php

/* 
 * display complete application
 *
 */
 
session_start();

if ( !( isset( $_SESSION['Username'] ) && isset( $_SESSION['Name'] ) ) )
{
	echo "You must login first to visit this page.";
	die();
}

if ( ! isset (  $_POST['app_id'] ) )
{
	echo "Sorry, there was a problem.<br>";
	die();
}
else
{
	$id = $_POST['app_id'];
	$type = $_POST['app_type'];


	require_once "../../LocalSettings.php";
	require_once "../Globals.php";
	
	$sqlconn = new mysqli ( $eorgDBserver, $eorgDBuser, $eorgDBpasswd, $eorgDBname );

	if ( $sqlconn->connect_errno )
	{
		echo "Internal Server Error, Sorry for inconvenience.";
		die();
	}
	
	$qry = "SELECT * FROM $type WHERE $AppId = ?";
	$stmt = $sqlconn->prepare ( $qry );
	$stmt->bind_param ( 's', $id );
	
	echo <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<title>Add User</title>

</head>

<body >

<h2>Application #[ $id ].</h2>

<table border = "15">

HTML;
	
	if ( ! $stmt->execute() )
	{
		echo "Sorry, there is a problem with database.";
		die();
	}
	else
	{
		$result = $stmt->get_result();
		$row = $result->fetch_array();
		
		$qr = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = \"$eorgDBname\" AND TABLE_NAME = \"$type\"";
		$cols = $sqlconn->query($qr);
		
		$i = 0;
		
		while( $col = $cols->fetch_array() )
		{	
			echo "<tr> <th>$col[0]</th> <td>".$row[$i]."</td> </tr>";
			$i++;
		}
	}
	
	echo <<<HTML
</table>

 
</body>
</html>
HTML;
}



?>
