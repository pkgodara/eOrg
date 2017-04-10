<?php

/* 
 * display application count to user
 *
 */
 
session_start();

require_once "../../LocalSettings.php";
require_once "../Globals.php";
require_once "countApplications.php";


$html = <<<HTML
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

$html2 = <<<HTML

<div id="table"> </div>


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

echo $html;

echo $html2;

?>
