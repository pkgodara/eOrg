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

// initial check for settings table.

$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $eorgDBname );

if( $sqlConn->connect_errno ) 
{
	echo "Error connecting database. Please check your database credentials and update.";
	die();
}

$qry = "SELECT * FROM $settings";

$stmt = $sqlConn->prepare($qry);

if( $sqlConn->errno == '1146' ) //table doesn't exist
{
	require 'installer/initSettings.php';
}



$html = <<<HTML
<html>
<head>
<title>Settings</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="/favicon.png" type="image/png">
<link rel="shortcut icon" type="image/png" href="../image/gogreen.jpg" />
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
HTML;
echo $html;
include 'Watch.php';

$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $eorgDBname );

if( $sqlConn->connect_errno ) 
{
	echo "Error connecting database. Please check your database credentials and update.";
	die();
}

$stmt = $sqlConn->prepare("SELECT * FROM $settings");

if ( ! $stmt->execute() )
{
	echo"there is a problem with database";
	die ();
}

$res = $stmt->get_result();
if ($res->num_rows == 0)
{
	echo "No Settings are available.";
	die();
}

echo "<br><br><center><form action=\"saveSettings.php\" method=\"post\"><table>";

while($row = mysqli_fetch_row($res))
{
	$newRow = preg_replace('/\s+/', '_', $row[0]);
	$newRow = str_replace('.', '$', $newRow);
	echo "<tr><td><h2>$row[0] :</h2></td><td> <input type='text' name=\"$newRow\" value=\"$row[1]\" ></td></tr> <br>";
}
echo "</table>";
$stmt->close();

$html = <<<HTML
<br>
<button type="submit" name="submit">Submit!</button>
</form>
</body>
</html>
HTML;


echo $html;

?>
