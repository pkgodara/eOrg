<?php
/*
 *
 * This is to update the categories table.
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


if ( !(isset($_POST['tab']) && isset($_POST['alreadyPresent']) && isset($_POST['catType']) && isset($_POST['levels']) ) )
{
	echo "Sorry, there is some problem<br>";
	die ();
}

$tab = $_POST['tab'];
$k = $_POST['alreadyPresent'];  //no. of elements already present in the category type
$catType = $_POST['catType'];
$lev = array();
$lev = $_POST['levels'];

$levId = str_replace ( "C", "L", $catType );

echo count($lev);
echo $levId;

$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $catDB );


/*
if( $sqlConn->connect_errno ) 
{
	echo "Error connecting database. Please check your database credentials and update.";
	die();
}


$qry = "SELECT * FROM $tab WHERE $levels REGEXP \"^$levId.$\"";
$stmt = $sqlConn->prepare ($qry) ;

if ( ! $stmt->execute() )
{
	echo"there is a problem with database<br>";
	die ();
}


$result = $stmt->get_result ();

// Creating the array of previous entries;
//
$prevLev = array();

$i = 0;  // array index

while ( $row = mysqli_fetch_row ( $result ) )
{
	$preLev[$i] = $row[0];
	$i++;
}

$stmt->close();


for ( $i = 0 ; $i < count($lev) ; $i++ )
{
	$val = $levId.($k+1) ;
	while ( in_array($val, $prevLev) )
	{
		$k++;
		$val = $levId.($k+1) ;
	}
	$stmt = $sqlConn->prepare("INSERT INTO $tab VALUES (?,?)");
		$stmt->bind_param('ss', $val , $lev[$i] );


		if( ! $stmt->execute() )
		{
			echo "Error in database.";
			die();
		}
		
		$stmt->close();
		
	$k++;
}

*/
echo "Updates have been made successsfully<br>";

echo "<br><a href="">home</a>";

?>
