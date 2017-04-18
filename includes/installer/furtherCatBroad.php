<?php
/*
 *
 * This is to further categorise the broad categories
 *
 */


session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && $_SESSION['Username'] === 'admin' ) )
{
	echo "To access this page you need to login as Admin. Please log in first.";
	die();
}


require_once "../../LocalSettings.php";
require_once "../Globals.php";


$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $catDB );

if( $sqlConn->connect_errno ) 
{
	echo "Error connecting database. Please check your database credentials and update.";
	die();
}


$qry = "SELECT TABLE_NAME FROM information_schema.tables WHERE table_schema = ?";
$stmt = $sqlConn->prepare( $qry );
$stmt->bind_param ( 's', $catDB );


if ( ! $stmt->execute() )
{
	echo"there is a problem with database<br>";
	die ();
}

$res = $stmt->get_result();

if ( $res->num_rows == 0 )
{
	echo "Sorry, first set the broad categories<br>";
	die ();
}


$html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<title>Further Categorization</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="/favicon.png" type="image/png">
<link rel="shortcut icon" type="image/png" href="../../image/gogreen.jpg" />
<style>
body {
    
    background-image: url("../../image/image4.jpg");
     min-height: 500px;
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}
input[type=text] {
    
    width: 400px;
   height:35px;
  font-size:25px;
}
button

{
	cursor: pointer; font-size : 25px; height:auto; width:auto ;background-color:#000000;color:white ;
	border: 0.25px solid white;
}
</style>
</head>



<body style = "color:white ;font-size:25px"><center><br><br><br><br><br><br>
<p>Please select an item to categorize :<br><br></p>
HTML;


echo $html;

while ( $row = mysqli_fetch_row ( $res ) )
{
	$tableName = str_replace('_', ' ', $row[0]);
	$qry2 = "SELECT * FROM $row[0] LIMIT 1"; // to take the level no. of the broad category
	$stmt2 = $sqlConn->prepare ( $qry2 );
	if ( ! $stmt2->execute () )
	{
		echo "Sorry problem with database<br>";
		die ();
	}
	$res2 = $stmt2->get_result ();
	$row2 = mysqli_fetch_row ( $res2 );
	echo "<input type='radio' id=$row2[1] name='users' value=$row2[0] onclick='showOptions(this)'>$tableName<div id=$row2[0]></div><hr><br>";
	$stmt2->close();
}	

$stmt->close();


$html = <<<HTML
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
function showOptions ( opted )
{
var xhttp;
xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function()
{
if (this.readyState == 4 && this.status == 200)
{
$("#"+opted.value).append(this.responseText);
}
};
xhttp.open("POST", "furtherCatBroad2.php", true);
xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xhttp.send("tab="+opted.id+"&levelId="+opted.value);
}
</script>
</body>
</html>
HTML;

echo $html;





?>
