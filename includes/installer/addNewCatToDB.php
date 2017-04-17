<?php
/*
 *
 * This is to initialize the category user database
 *
 */


session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && $_SESSION['Username'] === 'admin' ) )
{
	echo "To access this page you need to login as Admin. Please log in first.";
	die();
}


if ( ! isset ( $_POST['submit'] ) )
{
	echo "Sorry, there is some problem with it<br>";
	die ();
}

require_once "../../LocalSettings.php";
require_once "../Globals.php";


$lev = array ();
$lev = $_POST['levels'];


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

// Starting the creation of tables after these many no. of tables.
//

$k = $res->num_rows;

//creating array of previously existing tables
//

$prevTab = array();
$j = 0; // index for $prevTab
while ($row = mysqli_fetch_row ($res))
{
	$prevTab[$j] = $row[0];
	$j++;
}

$stmt->close();

$j = 1; //for further use of j while filling the entries of the tables

for ( $i = 0 ; $i < count ( $lev ) ; $i++ )
{
	$LEV = preg_replace('/\s+/', '_', $lev[$i]);
	$query = "CREATE TABLE IF NOT EXISTS $LEV ( $levels VARCHAR(200) NOT NULL, $levelName VARCHAR(50) NOT NULL, INDEX idx USING BTREE ($levels) )";

	$stmt = $sqlConn->prepare( $query );


	if ( ! $stmt->execute() ) // if unsuccessful
	{
		echo "Error in database.";
		die();
	}

	$stmt->close();
	
	if($lev[$i] === "")
	{
	}
	else if ( ! in_array($lev[$i], $prevTab) )
	{
		$val = "L_".($j+$k);
		$j++;
		$stmt = $sqlConn->prepare("INSERT INTO $lev[$i] VALUES (?,?)");
		$stmt->bind_param('ss', $val , $lev[$i] );


		if( ! $stmt->execute() )
		{
			echo "Error in database.";
			die();
		}
		
		$stmt->close();
	}
}


$html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="shortcut icon" href="/favicon.png" type="image/png">
<link rel="shortcut icon" type="image/png" href="../../image/gogreen.jpg" />
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
<center><b><i><br><br><br><br><br><br>
HTML;
echo $html;

echo "The entered broad categories has been updated in the database successfully<br>";

echo "for further categorisation please click <a href='addNewCat.php'>here</a><br>";

echo "<br><a href='../../'>GO HOME</a><br>";





?>
