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
	require "../ApplHandlingByStr.php";
	
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


<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>


body {
    color:white;
    background-image: url("../../image/image4.jpg");
     min-height: 500px;
    background-attachment: fixed;
    background-position: center;
   
    background-size: cover;
    background-repeat: no-repeat;
}
table, td, th {
    font-size:25px;
    text-align:center;
    border: 1px solid black;
}

table {
    width: 100%;
    border-color: white;
}

th {
    height: 50px;
}

button
{
	cursor: pointer; font-size : 25px; height:auto; width:auto ;background-color:transparent;color:white ;
	border: 0.25px solid white;
}
</style>
</head>

<body ><br<br><br<br><br><br<br><br><br>
HTML;

echo "$html";

if ($_SESSION['PostName'])
{
echo "<button onclick=\"document.location.href='../dashboard/PostDashBoard.php'\" > HOME </button> ";
}
else
echo "<button onclick=\"document.location.href='../../'\" > HOME </button> ";


$html = <<<HTML
<button onclick="document.location.href='handleAppl.php'" > BACK </button>
<center><b><i><br><br><br<br><br<br><br>

<center><i>

<h2 style = "font-size:35px"><b>Application #[ $id ].</b></h2>

<table border = "15">

HTML;
echo "$html";

	
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
			if( $col[0] == $stat )
			{
				echo "<tr> <th>$col[0]</th>";
				showFullStatus( $row[$i] );
				echo "</tr>";
			}
			else
			{
				echo "<tr> <th>$col[0]</th> <td>".$row[$i]."</td> </tr>";
			}
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
