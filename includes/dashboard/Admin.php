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
    background-image: url("../../adminpic.jpg");
}
</style>
<title>Admin</title>

</head>
<center>
<body>
<br><br><br><br>
<h2>Hello
HTML;

$html2 = <<<HTML
</h2>
<br><br><br><br>
<button onclick="document.location.href='../installer/broadCatUsers.php'" style="cursor: pointer; font-size : 25px; height:auto; width:150px ;background-color:#8B4513;color:white ;border:10px "> Add category(s) </button>
<button onclick="document.location.href='../Post/CreatePost.php' "style=" cursor: pointer; font-size : 25px; height:auto; width:150px ;background-color:#8B4513;color:white ;border:10px "> Create Post </button>

<button onclick="document.location.href='../application/createApplnType.php'" style="cursor: pointer; font-size : 25px; height:auto; width:150px ;background-color:#8B4513;color:white ;border:10px "> Create a type of application </button>

<button onclick="document.location.href='../application/ApplnPaths.php'" style="cursor: pointer; font-size : 25px; height:auto; width:150px ;background-color:#8B4513;color:white ;border:10px "> Create path(s) of Application </button>

<button onclick="document.location.href='../AssignPost.php'" style="cursor: pointer; font-size : 25px; height:auto; width:150px ;background-color:#8B4513;color:white ;border:10px "> Assign a POST </button>



<button onclick="document.location.href='../AddUser.php'" style="cursor: pointer; font-size : 25px; height:auto; width:150px ;background-color:#8B4513;color:white ;border:10px "> Add User </button>

<button onclick="document.location.href='../EditUser.php'"style=" cursor: pointer;font-size : 25px; height:auto; width:150px ;background-color:#8B4513;color:white ;border:10px "> Edit User </button>

<button onclick="document.location.href='../RemoveUser.php'"style=" cursor: pointer;font-size : 25px; height:auto; width:auto ;background-color:#8B4513;color:white ;border:10px "> Remove User </button>


<button onclick="document.location.href='../Logout.php'"style=" cursor: pointer;font-size : 25px; height:auto; width:auto ;background-color:#8B4513;color:white ;border:10px "> Modify Category </button>

<button onclick="document.location.href='../Logout.php'"style="cursor: pointer; font-size : 25px; height:auto; width:150px ;background-color:#8B4513;color:white ;border:10px "> Log out ! </button>
<br><br><br><br>

HTML;

echo $html1;
echo " ".$_SESSION['Name'];



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
echo "<pre>	User ID			Name			Sex 		Designation(s)<br><br></pre>";
$qry = "SELECT * FROM $loginDB " ;
$stmt = $sqlConn->prepare ( $qry );
$stmt->execute ( );
$result = $stmt->get_result();
while ( $row = mysqli_fetch_row ( $result ) )
{
	echo "<pre>$i.	$row[0]			$row[2]			$row[3]			$row[4]<br></pre>";
	$i = $i + 1;
}
$stmt->close();
$sqlConn->close();


echo "</center></body> </html>";

?>
