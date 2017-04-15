<?php

/* 
 * display application count to user
 *
 */

session_start();

if ( !( isset( $_SESSION['Username'] ) && isset( $_SESSION['Name'] ) ) )
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
<}
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
	cursor: pointer; font-size : 25px; height:auto; width:auto ;background-color:#000000;color:white ;
	border: 0.25px solid white;
}
</style><meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>

th {
    height: 50px;
}

button
{
	cursor: pointer; font-size : 25px; height:auto; width:auto ;background-color:#000000;color:white ;
	border: 0.25px solid white;
}

</style>
</head>

<body ><button onclick="document.location.href='../dashboard/User.php'"> HOME </button>
<center><br><br>
<h2>Please Select Date or Month or Year to get count</h2><br>

Select Date : <input type="date" name="date" id="date" placeholder="yyyy-mm-dd" required/>
<br><br>
Applications on : 
<select id="choice"  style = "cursor:pointer; font-size : 25px; height:auto; width:auto ;background-color:black;color:white ;border:10px">
<option value="year" >Year</option>
<option value="month" >Month</option>
<option value="day" selected >Full Date</option>
</select>
<br><br><br><br><br><br><br>
<button name="submit" id="submit" >Get Count</button>

HTML;

echo <<<HTML

<div id="table">
<table><br>
<caption style ="text-align:center">Your Total Applications Till Now</caption>

<tr>
<td>Application type</td>
<td>Total No of App.</td>
</tr>

HTML;

	$result = totalApplnTillNow( $_SESSION['Username'] );

	foreach( $result as $key => $value )
	{
		echo "<tr><th>$key</th><td>$value</td></tr>" ;
	}


echo <<<HTML

</table>
</div>


<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>

<script>
$(document).ready(function() {
	$("#submit").click( function() {
		var dt = $("#date").val();
		var ch = $("#choice").val();
		var date = "date=" + dt + "&choice=" + ch ;
		
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
