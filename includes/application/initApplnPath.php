<?php
/*
 *
 * This is to initilise the application paths for different groups of the people to a table.
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



$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $applnDB );
$sqlConnEorg = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $eorgDBname );

if( $sqlConn->connect_errno ) 
{
	echo "Error connecting database. Please check your database credentials and update.";
	die();
}

if ( !(isset($_POST['applnType']) && isset($_POST['groupCode']) && isset($_POST['postSequence'])) )
{
	echo "Sorry, there is some problem<br>";
	die();
}

$applnType = $_POST['applnType'];

$groupCode = $_POST['groupCode'];

$postSequence = array();
$postSequence = $_POST['postSequence'];
$postStr = "";  // a string of the post(s) seperated by semicolon ';'

for($i = 0 ; $i < (count($postSequence) - 1) ; $i++) 
{
	$postStr = $postStr.$postSequence[$i].";" ;
}
$postStr = $postStr.$postSequence[$i] ;



$stmt = $sqlConnEorg->prepare("CREATE TABLE IF NOT EXISTS $applnPathTable ( $groupId VARCHAR(200) NOT NULL, INDEX idx USING BTREE ($groupId))");

if( !$stmt->execute() )
{
	echo "Error in database.";
	die();
}

$stmt->close();


$stmt = $sqlConn->prepare("SELECT TABLE_NAME FROM information_schema.tables WHERE table_schema = \"$applnDB\"");

if ( ! $stmt->execute() )
{
	echo"there is a problem with database<br>";
	die ();
}

$res = $stmt->get_result();

if ($res->num_rows == 0)
{
	echo "No application type(s) are available, create them first.<br>";
	die();
}

$applnTypeArray = array();  // to store the available post(s)
$i = 0;			// counter to the array index
while ( $row = mysqli_fetch_row($res) )
{
	if($row[0] != $applnPathTable)
	{
		$applnTypeArray[$i] = $row[0];
		$i++;
	}
}

$stmt->close();

$stmt = $sqlConnEorg->prepare("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = \"$eorgDBname\" AND TABLE_NAME = \"$applnPathTable\"");

if ( ! $stmt->execute() )
{
	echo"there is a problem with database<br>";
	die ();
}

$res = $stmt->get_result();

$columnArray = array();  // to store the available colunm(s)
$i = 0;			 //counter for the array

while ( $row = mysqli_fetch_row($res) )
{
	$columnArray[$i] = $row[0];
	$i++;
}

$stmt->close();


for ($i = 0 ; $i < count($applnTypeArray) ; $i++)
{
	if ( ! in_array($applnTypeArray[$i], $columnArray) )
	{
		$stmt = $sqlConnEorg->prepare("ALTER TABLE $applnPathTable ADD $applnTypeArray[$i] VARCHAR(500)");
		if ( ! $stmt->execute() )
		{
			echo"there is a problem with database<br>";
			die ();
		}
		$stmt->close();
	}
}


$stmt = $sqlConnEorg->prepare("SELECT $groupId FROM $applnPathTable WHERE $groupId = \"$groupCode\"");

if ( ! $stmt->execute() )
{
	echo"there is a problem with database<br>";
	die ();
}

$res = $stmt->get_result();

if ($res->num_rows == 0)
{
	$stmt2 = $sqlConnEorg->prepare("INSERT INTO $applnPathTable ($groupId, $applnType) VALUES (\"$groupCode\", \"$postStr\")");
	if ( ! $stmt2->execute() )
	{
		echo "there is a problem with database<br>";
		die ();
	}
	$stmt2->close();
}
else
{
	$stmt2 = $sqlConnEorg->prepare("UPDATE $applnPathTable SET  $applnType = \"$postStr\" WHERE $groupId = \"$groupCode\"");
	if ( ! $stmt2->execute() )
	{
		echo"there is a problem with database<br>";
		die ();
	}
	$stmt2->close();
}

$stmt->close();

$html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
a:link    {color:red;  text-decoration:none}/*link color when not visited anytime*/
a:visited {color:red;  text-decoration:none}/*link coloe after visiting*/
a:hover   {color:white;  text-decoration:none}/*link color when try to click the link*/
a:active  {color:red; background-color:transparent; text-decoration:none}/*link color juat after clicking if active*/


body {
	
    font-size:30px;
    color:white;
    background-image: url("../../image/image4.jpg");
     min-height: 500px;
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}
</style>
</head>

<body>
<center><b><i>
HTML;

echo $html;

echo "Successfully created<br><br>";
echo "<a href='ApplnPaths.php'>CREATE ANOTHER</a><br>";
echo "<a href='../../'>HOME</a><br>";
echo"</center></body></html>";

?>
