<?php
/*
 *
 * This is the extension to further categorise the broad categories
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


if ( !(isset($_POST['tab']) && isset($_POST['levelId'])) )
{
	echo "Sorry, there is some problem<br>";
	die ();
}



$tab = $_POST['tab'];
$levId = $_POST['levelId'];


$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $catDB );

if( $sqlConn->connect_errno ) 
{
	echo "Error connecting database. Please check your database credentials and update.";
	die();
}


$qry = "SELECT * FROM $tab WHERE $levels REGEXP \"^$levId.$\"";
$stmt = $sqlConn->prepare($qry);

if ( ! $stmt->execute() )
{
	echo"there is a problem with database<br>";
	die ();
}

$result = $stmt->get_result ();

$catType = str_replace ( "L", "C", $levId );

if ( $result->num_rows == 0 )
{
	echo "enter the 'type' of this category (eg. say the categories are CSE, ME, EE, etc. then its category type would be 'deparement' ) : ";
$html = <<<HTML
<form  action="updateCatTable.php" method="post">
<input type="text" name="catType" required="required"><br>
<input type="radio" name="tab" value="$tab" checked>Now, enter the categories<br>
<input type="radio" name="levelId" value="$levId" checked>one by one<br>
<div id="afterClick">
Category Name(s) : <input type="text" name="levels[]" required="required">
<button type="button" id="1" onclick="addAnother()" >Want to add another</button>
</div>
<br><button type='submit' name='submit'>Done with it !</button><br>
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
var i = 1;
function addAnother ()
{
//hiding the previous button
//
$("#"+i).hide();
i++;
//asking to add another or done with adding
//
$("#afterClick").append("<br><input type='text' name='levels[]' required='required'><button type='button' id='"+i+"' onclick='addAnother ()' >Want to add another</button><br>");
}
</script>
HTML;


	echo $html;
}
else
{
	$qry2 = "SELECT * FROM $tab WHERE $levels REGEXP \"^$catType$\"";
	$stmt2 = $sqlConn->prepare($qry2);
	if ( ! $stmt2->execute() )
	{
		echo"there is a problem with database<br>";
		die ();
	}
	$res2 = $stmt2->get_result();
	if ( $res2->num_rows == 0 )
	{
		echo "Sorry there is some problem<br>";
		die();
	}
	$row2 = mysqli_fetch_row ($res2);
	echo "<br>".$row2[1].":<br>";
	$stmt2->close();
	while ( $row = mysqli_fetch_row ($result) )
	{
		echo "<input type='radio' name=$catType id=$tab value=$row[0] onclick='showOptions (this)' >$row[1]<hr><div id=$row[0]></div><hr>";
	}
	$stmt->close();
	
}




?>
