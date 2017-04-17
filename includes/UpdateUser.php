<?php


session_start();

require_once "../LocalSettings.php";
require_once "Globals.php";


if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && $_SESSION['Username'] == 'admin' ) )
{
	echo "session id :".session_id()." ,You need to login as Admin to remove users. Please log in as/contact Admin.";
	die();
}


$change = <<<HTML
<!DOCTYPE html >
<html>
<head>
<link rel="shortcut icon" href="/favicon.png" type="image/png">
<link rel="shortcut icon" type="image/png" href="../image/gogreen.jpg" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style> 

button
{
	cursor: pointer; font-size : 25px; height:auto; width:auto ;background-color:#000000;color:white ;
	border: 0.25px solid white;
}

body {
	
    font-size:30px;
    color:white;
    background-image: url("../image/image4.jpg");
     min-height: 500px;
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}


</style>
</head>
<body ><center><b><i>
<br><br><br>
<button onclick="document.location.href='../'" > HOME</button><br><br>
<button onclick="document.location.href='EditUser.php'" > Edit Another User</button><br><br>

HTML;
echo $change;

if( isset( $_POST['submit']) )
{
	$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $eorgDBname );

	if( $sqlConn->connect_errno ) 
	{
		echo "Server error.";
		die();
	}

	$updt = "UPDATE $loginDB SET $FName = \"".$_POST['flname']."\", $Sex = \"".$_POST['sex']."\" WHERE $UName = \"".$_POST['name']."\"";

$stmt = $sqlConn->prepare($updt);


	if( $stmt->execute() )
	{
		print "Record updated successfully";
	}
	else
	{
		echo "Error updating record.";
		print "<br>Try again";
	}

}
else
{
	echo "Please enter details.";
	die();
}

echo "</body></html>";
?>
