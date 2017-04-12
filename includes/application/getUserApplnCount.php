<?php

/* 
 * display application count to user
 *
 */

session_start();

if ( !( isset( $_SESSION['Username'] ) && isset( $_SESSION['Name'] ) && isset( $_SESSION['PostName'] ) ) )
{
	echo "You must login first to visit this page.";
	die();
}

require_once "../../LocalSettings.php";
require_once "../Globals.php";
require_once "countApplications.php";


echo <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<title>Application Count</title>

</head>

<body >

<h2>Please Select Username AND Date or Month or Year to get count</h2>
Username : <input type="text" name="user" id="user" required/> <br>
Select Date : <input type="date" name="date" id="date" placeholder="yyyy-mm-dd" required/>
<br>
Applications on : 
<select id="choice">
<option value="year" >Year</option>
<option value="month" >Month</option>
<option value="day" selected>Full Date</option>
</select>
<br>
<button name="submit" id="submit" >Get Count</button>

<div id="table">
</div>


<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>

<script>
$(document).ready(function() {
	$("#submit").click( function() {
		var dt = $("#date").val();
		var ch = $("#choice").val();
		var us = $("#user").val();
		var date = "date=" + dt + "&choice=" + ch + "&user=" + us ;
		
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
