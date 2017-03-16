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

$html1 = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<title>Admin</title>

</head>

<body style ="background-color:LightSlateGray">

<h2>Hello
HTML;

$html2 = <<<HTML
</h2>

<button onclick="document.location.href='../AddUser.php'"> Add User </button>

<button onclick="document.location.href='../EditUser.php'"> Edit User </button>

<button onclick="document.location.href='../RemoveUser.php'"> Remove User </button>

<button onclick="document.location.href='../Logout.php'"> Log out ! </button>


HTML;

echo $html1;
echo " ".$_SESSION['Name'];



echo $html2;
echo "<br><br><br>The available users are :<br><br>";

require_once "../../LocalSettings.php";
require_once "../Globals.php";

$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $eorgDBname );

if( $sqlConn->connect_errno ) 
{
		echo "Internal Server Error, Contact Administrator.";
			die();
}

$i = 1;
echo "<pre>	User ID			Name			Designation(s)<br><br></pre>";
$qry = "SELECT * FROM $loginDB " ;
$stmt = $sqlConn->prepare ( $qry );
$stmt->execute ( );
$result = $stmt->get_result();
while ( $row = mysqli_fetch_row ( $result ) )
{
	echo "<pre>$i.	$row[0]			$row[2]			$row[3]<br></pre>";
	$i = $i + 1;
}
$stmt->close();
$sqlConn->close();


echo "</body> </html>";

?>
