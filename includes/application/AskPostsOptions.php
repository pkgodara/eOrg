<?php
/*
 *
 * This is to give options of the available posts.
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



$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $eorgDBname );

if( $sqlConn->connect_errno ) 
{
	echo "Error connecting database. Please check your database credentials and update.";
	die();
}


$stmt = $sqlConn->prepare("SELECT $NameOfThePost FROM $PostTable");

if ( ! $stmt->execute() )
{
	echo"there is a problem with database<br>";
	die ();
}

$res = $stmt->get_result();

if ($res->num_rows == 0)
{
	echo "No POST(s) are available, create post(s) first.<br>";
	die();
}

$html = <<<HTML
<select name="posts" onchange="askAnotherPost(this)" required>
<option value="">Select post(s) from here</option>
HTML;

echo $html;

while($row = mysqli_fetch_row($res))
{
	echo "<option value=$row[0]>$row[0]</option>";
}



echo "</select>";

?>
