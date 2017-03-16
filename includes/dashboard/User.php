<?php

/* 
 * dashboard for user
 */

session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) ) )
{
	echo "To access this page you need to login. Please log in first.";
	die();
}

$html1 = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<title>Student</title>

</head>

<body style ="background-color:MediumAquaMarine ">

<h2>Hello
HTML;

$html2 = <<<HTML
</h2>

<button onclick="document.location.href='../application/LeaveAppl.php'"> Generate Leave Application </button>

<button onclick="document.location.href='../application/handleAppl.php'"> Handle Applications </button>

<button onclick="document.location.href='../Logout.php'"> Log out ! </button>

HTML;

echo $html1;
echo " ".$_SESSION['Name'];
echo $html2;



require_once "../../LocalSettings.php";
require_once "../Globals.php";

$user= str_replace('.','$',$_SESSION['Username'] );

$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $eorgDBname );

if( $sqlConn->connect_errno ) 
{
	echo "Internal Server Error, Contact Administrator.";
	die();
}

$qry = "SELECT * FROM $user";
$stmt = $sqlConn->prepare($qry);
$stmt->execute();
$result = $stmt->get_result();
$i=1;

echo "<pre>  Aplication-id     Aplication-Type<br><br></pre>";

while($row = mysqli_fetch_row($result))
{

echo "<pre>$i. $row[0]               $row[1]<br><br></pre>";
$i=$i+1;

}

$stmt->close();
$sqlConn->close();


echo "</body></html>";

?>
