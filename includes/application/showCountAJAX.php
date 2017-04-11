<?php

/* 
 * handle AJAX call for showing application count
 *
 */

session_start();

if ( !( isset( $_SESSION['Username'] ) && isset( $_SESSION['Name'] ) ) )
{
	echo "You must login first to visit this page.";
	die();
}

$date = $_POST['date'];
$choice = $_POST['choice'];

if( $date != "" ) 
{
	require_once "countApplications.php";

	$user = $_SESSION['Username'];
	
	$dt = explode('-',$date);


echo "<table>";

	$result ;

	if( count($dt) == 3 || $choice == 'year' )
	{
		$result = countApplnOnDay( $user, $dt[2] , $dt[1] , $dt[0] );
		echo "<caption style ="color:blue;text-align:center">Your application count On Day $dt</caption>";
	}
	else if( count($dt) == 2 || $choice == 'month' )
	{
		$result = countApplnInMonth( $user , $dt[1] , $dt[0] );
		echo "<caption style ="color:blue;text-align:center">Your Application Count In Month $dt</caption>";
	}
	else if( count($dt) == 1 || $choice == 'day' )
	{
		$result = countApplnInYear( $user , $dt[0] );
		echo "<caption style ="color:blue;text-align:center">Your Application Count In Year $dt</caption>";
	}
	else
	{
		echo "date format not correct. Date should be: yyyy OR yyyy-mm OR yyyy-mm-dd";
	}

	echo "<tr><td>Application type</td><td>Total No of App.</td></tr>";

	foreach( $result as $key => $value )
	{
		echo "<tr><th>$key</th><td>$value</td></tr>" ;
	}

	echo "</table>";
}


?>
