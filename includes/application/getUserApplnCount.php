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
<link rel="shortcut icon" href="/favicon.png" type="image/png">
<link rel="shortcut icon" type="image/png" href="../../image/gogreen.jpg" />
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


input[type=button],select
{
	cursor: pointer; font-size : 25px; height:auto; width:auto ;background-color:black;color:white ;
	border: 0.25px solid white;
}
button{
	cursor: pointer; font-size : 25px; height:auto; width:auto ;background-color:transparent;color:white ;
	border: 0.25px solid white;
}




</style>




</head>
<body><br><br><button onclick="document.location.href='../dashboard/PostDashBoard.php'" > HOME </button>
<center>
<br><br><br>
<h2>Please Select Username AND Date or Month or Year to get count</h2><br>
Username : <input type="text" name="user" id="user" required/> <br><br><br>
Select Date : <input type="date" name="date" id="date" placeholder="yyyy-mm-dd" required/>
<br><br><br><br>
Applications on : 
<select id="choice">
<option value="year" >Year</option>
<option value="month" >Month</option>
<option value="day" selected>Full Date</option>
</select>
<br><br><br><br><br><br><br>
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
