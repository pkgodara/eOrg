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

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>


body {
    
    background-image: url("../../image/image1.jpg");
     min-height: 500px;
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
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
	cursor: pointer; font-size : 25px; height:auto; width:auto ;background-color:#004d33;color:white ;border:10px;
}

</style>

</head>

<body style ="font-size:30px">
HTML;

echo $html1;
include 'Watch.php';


echo"<center><b><i><h1>Hello";
echo " ".$_SESSION['Name'];

$html2 = <<<HTML
</h1>

<button onclick="document.location.href='../application/LeaveAppl.php'" > Generate Leave Application </button>

<button onclick="document.location.href='../application/handleAppl.php'" > Handle Applications </button>

<button onclick="document.location.href='../application/ShowApplCount.php'" > Application Count </button>

<button onclick="document.location.href='resetPassword.php'" > Reset Password </button>

<button onclick="document.location.href='../Logout.php' "> Log out ! </button>

HTML;



echo $html2;



require_once "../../LocalSettings.php";
require_once "../Globals.php";



$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $eorgDBname );

if( $sqlConn->connect_errno ) 
{
	echo "Internal Server Error, Contact Administrator.";
	die();
}
$user = $_SESSION['Username'];
$stmt = $sqlConn->prepare("SELECT $postTitle FROM $assignPostTable WHERE $assignedUser = \"$user\"");
if ( ! $stmt->execute() )
{
	echo"there is a problem with database<br>";
	die ();
}

$res = $stmt->get_result();

if ($res->num_rows != 0)
{
	echo "<select name='posts' id='posts' onchange='callForChange(this)' style='cursor: pointer; font-size : 25px; height:auto; width:auto ;background-color:#004d33;color:white ;border:10px '>";
	echo "<option value=''>Select the post(s)</option>";
	while($row = mysqli_fetch_row ($res))
	{
		echo "<option value='$row[0]'>$row[0]</option>";
	}
	echo "</select>";
echo <<<HTML
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
function callForChange(opted)
{
var xhttp;
xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function()
{
if (this.readyState == 4 && this.status == 200)
{
window.location = "PostDashBoard.php";
}
};
xhttp.open("POST", "forwardPost.php", true);
xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xhttp.send("post="+opted.value);
}
</script>
<br><br><br><br>
HTML;
}



$stmt->close();

$user= str_replace('.','$',$_SESSION['Username'] );

$qry = "SELECT * FROM $user";
$stmt = $sqlConn->prepare($qry);
$stmt->execute();
$result = $stmt->get_result();
$i=1;

$html = <<<HTML
<table>
<tr>
<th>Sr. No.</th>
<th>Application-id</th>
<th>Application-Type</th>
</tr>
HTML;

echo $html;

while($row = mysqli_fetch_row($result))
{

$html = <<<HTML
<tr>
<td>$i.</td>
<td>$row[0]</td>
<td>$row[1]</td>
</tr>
HTML;

	echo $html;
	$i=$i+1;

}

$stmt->close();
$sqlConn->close();



echo "</table></i></b></center></body></html>";

?>
