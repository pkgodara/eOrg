<?php
/*
 *
 * This is to initialise the application type database.
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


$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $applnDB  );

if( $sqlConn->connect_errno ) 
{
	echo "Error connecting database. Please check your database credentials and update.";
	die();
}

if ( !( isset($_POST['applnTypeName']) && isset($_POST['submit']) ) )
{
	echo "Sorry, there is some problem<br>";
	die();
}


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

button,select
{
	cursor: pointer; font-size : 25px; height:auto; width:auto ;background-color:#000000;color:white ;
	border: 0.25px solid white;
}
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




$applnType  = $_POST['applnTypeName'];
 
$inputFields = array();
$inputFields = $_POST['inputFields'];

// checking wether the application type name is 'leave'(not case sensitive) or not, because 'leave' is a keyword in php
//
if (!strcasecmp($applnType,"leave"))
{
	echo "You cannot use the word 'leave'(not case sensitive) alone for this case.Please use some other word also with it(e.g., Duty leave, etc.).Fill it again<br>";
	die();
}

//replacing '.' and spaces fron the name
//
$applnType = preg_replace('/\s+/', '_', $applnType);
$applnType = str_replace('.', '$', $applnType);


// checkinh wether this table already exists or not in the database
//

$qry = "SELECT TABLE_NAME FROM information_schema.tables WHERE table_schema = ?";
$stmt = $sqlConn->prepare( $qry );
$stmt->bind_param ( 's', $applnDB );


if ( ! $stmt->execute() )
{
	echo"there is a problem with database<br>";
	die ();
}



$res = $stmt->get_result();
$prevTab = array();	// array for previous tables
$i = 0;			// index for the array

while ( $row = mysqli_fetch_row ($res) )
{
	$prevTab[$i] = $row[0];
	$i++;
}

$stmt->close();


$qry = "CREATE TABLE IF NOT EXISTS $applnType ( $entries VARCHAR(200) NOT NULL, INDEX idx USING BTREE ($entries))";

$stmt = $sqlConn->prepare( $qry );



if( !$stmt->execute() )
{
	echo "Error in database.";
	die();
}


$stmt->close();




if ( !(in_array($applnType, $prevTab)) )
{
	if (isset($_POST['isStartDate']))
	{
		$stmt = $sqlConn->prepare("INSERT INTO $applnType VALUES ('Start Date')");
		
		if ( ! $stmt->execute() )
		{
			echo"there is a problem with database<br>";
			die ();
		}
		
		$stmt->close();
	}
	
	
	if (isset($_POST['isEndDate']))
	{
		$stmt = $sqlConn->prepare("INSERT INTO $applnType VALUES ('End Date')");
		
		if ( ! $stmt->execute() )
		{
			echo"there is a problem with database<br>";
			die ();
		}
		
		$stmt->close();
	}
	
	for ( $i = 0 ; $i < count($inputFields) ; $i++ )
	{
		$stmt = $sqlConn->prepare("INSERT INTO $applnType VALUES (?)");
		$stmt->bind_param ('s', $inputFields[$i] );
		
		if ( ! $stmt->execute() )
		{
			echo"there is a problem with database<br>";
			die ();
		}
		
		$stmt->close();
	}
	
	echo "Successfully created the application type<br>";
}
else
{
	echo $_POST['applnTypeName']." name already exists, try another<br>";
	
}


echo "<a href='createApplnType.php'>CREATE ANOTHER</a><br>";
echo "<a href='../../'>HOME</a><br>";


echo"</center></body></html>";
?>
