<?php

/* 
 * Leave application generation for users.
 *
 */

session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) ) )
{
	echo "You need to login to generate leave applications. Please log in.";
	die();
}

require_once "../../LocalSettings.php";
require_once "../Globals.php";

$html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<title>Add User</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>


body {
    color:white;
    background-image: url("../../image/image4.jpg");
     min-height: 500px;
    background-attachment: fixed;
    background-position: center;
   
    background-size: cover;
    background-repeat: no-repeat;
}
table, td, th {
    font-size:25px;
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
input[type=text] {
    width: 100%;
   height:50px;
   font-size:25px;
   autofocus;
}

button
{
	cursor: pointer; font-size : 25px; height:auto; width:auto ;background-color:transparent;color:white ;
	border: 0.25px solid white;
}
</style>

</head>

<body >
<button onclick="document.location.href='../dashboard/User.php' ">HOME</button>
<center>

<h2>Please Enter Credentials.</h2>

<form action="../AppLeave.php" method="post">



HTML;



$html2 = <<<HTML
</table>
<br><br>
<button type = "submit" >SUBMIT</button>
</form>
 
</body>
</html>
HTML;

echo $html;

$sqlconn = new mysqli ( $eorgDBserver, $eorgDBuser, $eorgDBpasswd , $applnDB);
$count = array();

$res = $sqlconn->query("SELECT TABLE_NAME FROM information_schema.tables WHERE table_schema = \"$applnDB\"");

echo "<tr><th>Type Of Application :</th><td><select id=\"appln\" name=\"appln\" style = \"cursor:pointer; font-size : 25px; height:auto; width:auto ;background-color:black;color:white ;border:10px\">";
echo "<option value=\"null\" selected desebled>SELECT </option>"; 

while( $row = mysqli_fetch_row($res) )
{
	$r = str_replace('_',' ',$row[0]);
	$r = str_replace('$','.',$r);
	echo "<option value=".$row[0]."> $r </option>";
}

echo "</select>";

echo <<<HTML
<table border = "15" id = "table">

<caption style ="color:blue;text-align:center"><h1><b></b></h1></CAPTION>
HTML;

$sqlconn->close();

echo <<<HTML
<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>

<script>
$(document).ready(function() {
	$("#appln").change( function() {
		var appln = $(this).val();
		var str = "appln="+appln;
		
		$.ajax( {
			type: "POST",
			url: "application.php",
			data: str,
			success: function( result ) {
				$("#table").html(result);
			}
		}); 
 	});
 });
</script>
HTML;

echo $html2;

?>
