<?php
/*
 *
 * This is to delete a category from the database
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


if ($res->num_rows == 0)
{
	echo "No categories available, create categories first.<br>";
	die();
}


$html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="/favicon.png" type="image/png">
<link rel="shortcut icon" type="image/png" href="../../image/gogreen.jpg" />
<style>

button
{
	cursor: pointer; font-size : 25px; height:auto; width:auto ;background-color:#000000;color:white ;
	border: 0.25px solid white;
}
body {
    font-size:30px;
    color:white;
    background-image: url("../../image/image4.jpg");
     min-height: 500px;
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}
</style>
</head>

<body>
<button onclick="document.location.href='../../'"> HOME </button>
<center><b><i><br><br><br><br><br><br>
<p>Select the category/branch(s) of a category to be deleted</p><br><br>
<div id="deleteOptions">
HTML;


echo $html;

while ($row = mysqli_fetch_row ($res))
{
	$newRow = str_replace('_', ' ', $row[0]);
	$qry2 = "SELECT * FROM $row[0] LIMIT 1"; // to take the level no. of the broad category
	$stmt2 = $sqlConn->prepare ( $qry2 );
	if ( ! $stmt2->execute () )
	{
		echo "Sorry problem with database<br>";
		die ();
	}
	$res2 = $stmt2->get_result ();
	$row2 = mysqli_fetch_row ( $res2 );
	echo "<input type='radio' name='users' id=$row2[0] value=$row[0] onclick='porvideButtons(this.value, this.id)'>$newRow";
	$stmt2->close();
}

$stmt->close();

$html = <<<HTML
</div><br>
<form action='deleteCatFromDB.php' method='post'>
<div id='backGround'>
</div><br>
<div id='giveButtons'>
</div>
</form><br>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
function porvideButtons(tab, lev)
{
$("#backGround").hide();
document.getElementById("backGround").innerHTML = "<input type='text' name='tab' value='"+tab+"' readonly><input type='text' name='levelId' value='"+lev+"' readonly>";
var temp = "\"provideBranches(\'"+tab+"\', \'"+lev+"\')\"";
document.getElementById("giveButtons").innerHTML = "To delete one of its branch : <button type='button' onclick="+temp+">Show Branches</button><br>Or,<br><button type='submit' name='submit'>Done! delete selected</button>";
}
function provideBranches(table, level)
{
$("#backGround").hide();
var xhttp;
xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function()
{
if (this.readyState == 4 && this.status == 200)
{
document.getElementById("deleteOptions").innerHTML = this.responseText;
}
};
xhttp.open("POST", "provideDeleteOptions.php", true);
xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xhttp.send("tab="+table+"&levelId="+level);
}
</script>
</body>
</head>
HTML;

echo $html;


?>
