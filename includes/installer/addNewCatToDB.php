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
	$query = "CREATE TABLE IF NOT EXISTS $lev[$i] ( $levels VARCHAR(200) NOT NULL, $levelName VARCHAR(50) NOT NULL, INDEX idx USING BTREE ($levels) )";

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
		$val = "L".($j+$k);
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

echo "The entered broad categories has been updated in the database successfully<br>";

echo "for further categorisation please click <a href='addNewCat.php'>here</a><br>";

echo "<br>GO HOME<br>";





?>
