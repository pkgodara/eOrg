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

$date = $_REQUEST['date'];
$choice = $_REQUEST['choice'];

if( $date != "" ) 
{
	require_once "countApplications.php";
	
	$user ;
	
	if( isset( $_SESSION['PostName'] ) )
	{
		$user = $_REQUEST['user'];
	}
	else
	{
		$user = $_SESSION['Username'];
	}
	
	$dt = explode('-',$date);


	echo "<table>";

	$result ;

	if( $choice == 'day' )
	{
		$result = countApplnOnDay( $user, $dt[2] , $dt[1] , $dt[0] );
		echo "<caption style =\"color:blue;text-align:center\">[ $user ] application count On Day ".$dt[2] ."-". $dt[1] ."-". $dt[0]."</caption>";
	}
	else if( $choice == 'month' )
	{
		$result = countApplnInMonth( $user , $dt[1] , $dt[0] );
		echo "<caption style =\"color:blue;text-align:center\">[ $user ] Application Count In Month ".$dt[1]."-".$dt[0]."</caption>";
	}
	else if( $choice == 'year' )
	{
		$result = countApplnInYear( $user , $dt[0] );
		echo "<caption style =\"color:blue;text-align:center\">[ $user ] Application Count In Year ".$dt[0]."</caption>";
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
