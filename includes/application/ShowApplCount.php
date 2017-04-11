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

</head>

<body >

<h2>Please Select Date</h2>

<input type="text" name="date" id="date" value="" placeholder="yyyy-mm-dd OR yyyy-mm OR yyyy" required/>

<button name="submit" id="submit" >Submit Application !</button>

HTML;

echo <<<HTML

<div id="table">
<table>
<caption style ="color:blue;text-align:center">Your Total Applications Till Now</caption>

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
		var date = "date="+dt;
	
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