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
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>


body {
    color:white;
    background-image: url("../../image/adminpic.jpg");
     min-height: 500px;
    background-attachment: fixed;
    background-position: center;
   
    background-size: cover;
    background-repeat: no-repeat;
}
table, td, th {
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
	cursor: pointer; font-size : 25px; height:auto; width:auto ;background-color:#000000;color:white ;border:10px;
}
</style>
<title>Admin</title>

</head>

<body>

HTML;
echo $html1;
include 'Watch.php';


$html2 = <<<HTML
<center><b><i>
<br><br><br><br>
<h2>Hello

HTML;
echo $html2;
echo " ".$_SESSION['Name'];
$html2 = <<<HTML


</h2>
<br><br><br><br>


<button onclick="document.location.href='../modifyCat.php'" > Modify category(s) </button>

<button onclick="document.location.href='../Post/CreatePost.php' "> Create Post </button>

<button onclick="document.location.href='../application/createApplnType.php'" > Create a type of application </button>

<button onclick="document.location.href='../application/ApplnPaths.php'" > Create path(s) of Application </button>

<button onclick="document.location.href='../AssignPost.php'"> Assign a POST </button>



<button onclick="document.location.href='../AddUser.php'" > Add User </button>

<button onclick="document.location.href='../EditUser.php'"> Edit User </button>

<button onclick="document.location.href='../RemoveUser.php'"> Remove User </button>

<br><br><br>


<button onclick="document.location.href='../Logout.php'"> Log out ! </button>

<br><br><br><br>

HTML;



echo $html2;
echo "<h2><br><br><br>The available users are :<br><br>";

require_once "../../LocalSettings.php";
require_once "../Globals.php";

$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $eorgDBname );

if( $sqlConn->connect_errno ) 
{
		echo "Internal Server Error, Contact Administrator.";
			die();
}

$i = 1;

$html = <<<HTML
<table>

<tr>
<th>Sr. No.</th>
<th>User ID</th>
<th>Name</th>
<th>Sex</th>
<th>Designation(s)</th>
</tr>
HTML;

echo $html;


$qry = "SELECT * FROM $loginDB " ;
$stmt = $sqlConn->prepare ( $qry );
$stmt->execute ( );
$result = $stmt->get_result();
while ( $row = mysqli_fetch_row ( $result ) )
{

$html = <<<HTML
<tr>
<td>$i.</td>
<td>$row[0]</td>
<td>$row[2]</td>
<td>$row[3]</td>
<td>$row[4]</td>
</tr>
HTML;

	echo $html;
	$i = $i + 1;
}
$stmt->close();
$sqlConn->close();


echo "</table></i></b></center></body> </html>";

?>
