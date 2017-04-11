<?php

/* 
 * display application count to user
 *
 */

session_start();

if ( !( isset( $_SESSION['Username'] ) && isset( $_SESSION['Name'] ) && isset( $_SESSION['PostName']) ) )
{
	echo "You must login first to visit this page.";
	die();
}

if ( ! isset (  $_POST['app_id'] ) )
{
	echo "Sorry, there was a problem.<br>";
	die();
}

$id = $_POST['app_id'];
$type = $_POST['app_type'];


require_once "../../LocalSettings.php";
require_once "../Globals.php";
require_once "countApplications.php";
require_once "../ApplHandlingByID.php";

echo <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<title>Application Count</title>

</head>

<body >

<h2>Please Select Date or Month or Year to get count</h2>

Select Date : <input type="date" name="date" id="date" placeholder="yyyy-mm-dd" required/>
<br>
Applications on : 
<select id="choice">
<option value="year" >Year</option>
<option value="month" >Month</option>
<option value="day" selected>Full Date</option>
</select>
<br>
<button name="submit" id="submit" >Submit Application !</button>

HTML;

$user = whoIsGenerator( $id , $type );

echo "<input type=\"text\" name=\"usr\" id=\"usr\" value=$user style=\"visibility: hidden; display: none;\" readonly>";

echo <<<HTML

<div id="table">
<table>
<caption style ="color:blue;text-align:center">Your Total Applications Till Now</caption>

<tr>
<td>Application type</td>
<td>Total No of App.</td>
</tr>

HTML;



echo <<<HTML

</table>
</div>


<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>

<script>
$(document).ready(function() {
	$("#submit").click( function() {
		var dt = $("#date").val();
		var ch = $("#choice").val();
		var usr = $("#usr").val();
		var date = "date=" + dt + "&choice=" + ch + "&user=" + usr ;
		
		$.ajax( {
			type: "POST",
			url: "showCountAJAX.php",
			data: date,
			success: function( result ) {
				$("#table").html(result);
			}
		}); 
	});
});
</script>

</body>
</html>
HTML;


?>
