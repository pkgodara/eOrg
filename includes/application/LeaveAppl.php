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

</head>

<body >

<h2>Please Enter Credentials.</h2>

<form action="../AppLeave.php" method="post">

<table border = "15">

<caption style ="color:blue;text-align:center"><h1><b>WELCOME</b></h1></CAPTION>
HTML;



$html2 = <<<HTML
</table>

<input type="submit" name="submit" value="Submit Application !" />
</form>
 
</body>
</html>
HTML;

echo $html;

$sqlconn = new mysqli ( $eorgDBserver, $eorgDBuser, $eorgDBpasswd , $applnDB);
$count = array();

$res = $sqlconn->query("SELECT TABLE_NAME FROM information_schema.tables WHERE table_schema = \"$applnDB\"");

echo "<tr><th>Type Of Application :</th><td><select id=\"appln\" name=\"appln\">";
echo "<option value=\"null\" selected> </option>"; 

while( $row = mysqli_fetch_row($res) )
{
	$r = str_replace('_',' ',$row[0]);
	$r = str_replace('$','.',$r);
	echo "<option value=".$row[0]."> $r </option>";
}

echo "</select> </td></tr></table>";

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
