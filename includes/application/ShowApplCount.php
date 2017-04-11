<?php

/* 
 * display application count to user
 *
 */
/* 
session_start();

if ( !( isset( $_SESSION['Username'] ) && isset( $_SESSION['Name'] ) ) )
{
	echo "You must login first to visit this page.";
	die();
}
 */
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

<h2>Please Select Date or Month or Year to get count</h2>

Select Date : <input type="date" name="date" id="date" required/>
<br>
Applications on : 
<input type="radio" name="choice" value="year" checked required> Year
<input type="radio" name="choice" value="month" > Month
<input type="radio" name="choice" value="day" > Full Date
<br>
<button name="submit" id="submit" onclick="f()" >Submit Application !</button>

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

function f(){
var c = document.getElementById("date").value;
var d = document.getElementById("choice").value;
var xhttp;
xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function()
{
if (this.readyState == 4 && this.status == 200)
{
document.getElementById("table").innerHTML = this.responseText;
}
};
xhttp.open("POST", "showCountAJAX.php", true);
xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xhttp.send("date="+c+"&choice="+d);}
</script>

</body>
</html>
HTML;

?>
