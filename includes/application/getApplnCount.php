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

<<<<<<< HEAD
=======
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

>>>>>>> a852fdbe82bb0fad2c9f01e8d02085b311781d5a
table {
    width: 100%;
    border-color: white;
}
<<<<<<< HEAD
=======

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
>>>>>>> a852fdbe82bb0fad2c9f01e8d02085b311781d5a

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
<body ><br><br>
     <button onclick="document.location.href='handleAppl.php'" > BACK </button>
<center><br><br><br><br><br><br>

<h2>Please Select Date or Month or Year to get count</h2>
<br>
Select Date : <input type="date" name="date" id="date" placeholder="yyyy-mm-dd" required/>
<br><br>
Applications on : 
<select id="choice">
<option value="year" >Year</option>
<option value="month" >Month</option>
<option value="day" selected>Full Date</option>
</select>
<br><br><br><br><br><br><br>
<button name="submit" id="submit" >Submit Application !</button>

HTML;

$user = whoIsGenerator( $id , $type );

echo "<input type=\"text\" name=\"usr\" id=\"usr\" value=$user style=\"visibility: hidden; display: none;\" readonly>";

echo <<<HTML

<div id="table">

<h2 style ="color:white;text-align:center">Your Total Applications Till Now</h2>
<table><br>

<br>
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
