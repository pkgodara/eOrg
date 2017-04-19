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

require_once "../LocalSettings.php";
require_once "Globals.php";


$html = <<<HTML
<html>
<head>
<title>Assign Post(s)</title>
<link rel="shortcut icon" href="/favicon.png" type="image/png">
<link rel="shortcut icon" type="image/png" href="../image/gogreen.jpg" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>


body {
    color:white;
    background-image: url("../image/image4.jpg");
     min-height: 500px;
    background-attachment: fixed;
    background-position: center;
   font-size:30px;
    background-size: cover;
    background-repeat: no-repeat;
}
input[type=text] {
    width: 200px;
   height:35px;
   font-size:25px;
}
button
{
	cursor: pointer; font-size : 25px; height:auto; width:auto ;background-color:#000000;color:white ;
	border: 0.25px solid white;
}
</style><br>
</head>
<body>

<button onclick="document.location.href='../' "> HOME </button> 

<center><b><i>
HTML;

echo $html;


$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $eorgDBname );

if( $sqlConn->connect_errno ) 
{
	echo "Error connecting database. Please check your database credentials and update.";
	die();
}

if(! isset($_POST['submit']))
{
	echo"Sorry, there is some problem";
	die();
}

$stmt = $sqlConn->prepare("SELECT $setKey FROM $settings");

if ( ! $stmt->execute() )
{
	echo"there is a problem with database<br>";
	die ();
}

$res = $stmt->get_result();

while ($row = mysqli_fetch_row($res))
{
	$newRow = preg_replace('/\s+/', '_', $row[0]);
	$newRow = str_replace('.', '$', $newRow);
	if( isset($_POST[$newRow]) )
	{
		echo $row[0]."<br>";
		
		$stmt2 = $sqlConn->prepare("UPDATE $settings SET $setValue = ? WHERE $setKey = \"$row[0]\"");
		$stmt2->bind_param ('s', $_POST[$newRow] );
		if ( ! $stmt2->execute() )
		{
			echo"there is a problem with database<br>";
			die ();
		}
		$stmt2->close();		
	}
}

echo "<br>Settings saved successfully.<br><br>";

echo "</body></html>";


?>
