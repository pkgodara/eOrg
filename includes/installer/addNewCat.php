<?php
/*
 *
 * This is to further categorise the broad categories
 *
 */


session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && $_SESSION['Username'] === 'admin' ) )
{
	echo "To access this page you need to login as Admin. Please log in first.";
	die();
}


require_once "../../LocalSettings.php";
require_once "../Globals.php";


$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $catDB );

if( $sqlConn->connect_errno ) 
{
	echo "Error connecting database. Please check your database credentials and update.";
	die();
}


$qry = "SELECT TABLE_NAME FROM information_schema.tables WHERE table_schema = ?";
$stmt = $sqlConn->prepare( $qry );
$stmt->bind_param ( 's', $catDB );


if ( ! $stmt->execute() )
{
	echo"there is a problem with database<br>";
	die ();
}

$res = $stmt->get_result();

if ( $res->num_rows == 0 )
{
	echo "Sorry, first set the broad categories<br>";
	die ();
}


$html = <<<HTML
<html>
<head>
<title>New Categorization</title>
</head>
<body>
<p>Please select an item to categorize :<br><br></p>
HTML;


echo $html;

while ( $row = mysqli_fetch_row ( $res ) )
{
	$qry2 = "SELECT * FROM $row[0] LIMIT 1"; // to take the level no. of the broad category
	$stmt2 = $sqlConn->prepare ( $qry2 );
	if ( ! $stmt2->execute () )
	{
		echo "Sorry problem with database<br>";
		die ();
	}
	$res2 = $stmt2->get_result ();
	$row2 = mysqli_fetch_row ( $res2 );
	echo "<input type='radio' id=$row2[1] name='users' value=$row2[0] onclick='showOptions(this)'>$row2[1]<hr><div id=$row2[0]></div><hr><br>";
	$stmt2->close();
}	

$stmt->close();


$html = <<<HTML
<p>Or to add category(s) to this, type them below and then hit 'done with it'</p>
<form  action="addNewCatToDB.php" method="post">
<div id="afterClick2">
<input type="text" name="levels[]" >
<button type="button" id="1" onclick="addMore()" >Want to add another</button>
</div>
<br><button type='submit' name='submit'>Done with it !</button><br>
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
var i = 1;
function addMore ()
{
//hiding the previous button 
//
$("#"+i).hide();
i++;
//asking to add another or done with adding
//

$("#afterClick2").append("<br><input type='text' name='levels[]' ><button type='button' id='"+i+"' onclick='addMore ()' >Want to add another</button><br>");
}
function showOptions ( opted )
{
var xhttp;
xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function()
{
if (this.readyState == 4 && this.status == 200)
{
$("#"+opted.value).append(this.responseText);
}
};
xhttp.open("POST", "addNewCat2.php", true);
xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xhttp.send("tab="+opted.id+"&levelId="+opted.value);
}
</script>
</body>
</html>
HTML;

echo $html;





?>
