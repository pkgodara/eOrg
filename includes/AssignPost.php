<?php
/*
 *
 * This is to assign post(s) to the user(s)
 *
 */


session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && $_SESSION['Username'] === 'admin' ) )
{
	echo "To access this page you need to login as Admin. Please log in first.";
	die();
}



require_once "../LocalSettings.php";
require_once "Globals.php";



$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $eorgDBname );

if( $sqlConn->connect_errno ) 
{
	echo "Error connecting database. Please check your database credentials and update.";
	die();
}


$html = <<<HTML
<html>
<head>
<title>Assign Post(s)</title>
</head>
<body>
<p>Assign the available post(s) to the usernames. Make sure that the username you provide must exist in the existing users otherwise it may causes problems in the future. However you can left some of the entries blank by now and assign them in future.<br><br></p>
<form action="AssignPostTable.php" method="post">
HTML;

echo $html;

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

while($row = mysqli_fetch_row($res))
{
	echo "$row[0] : <input type='text' name=$row[0] ><br>";
}

$stmt->close();

$html = <<<HTML
<br>
<button type="submit" name="submit">Submit!</button>
</form>
</body>
</html>
HTML;


echo $html;



?>
