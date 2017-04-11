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

if( $date != "" ) 
{
	require_once "countApplications.php";

	$user = $_SESSION['Username'];
	
	$dt = explode('-',$date);

echo <<<HT
<table>
<caption style ="color:blue;text-align:center">Your Application Count</caption>
<tr>
<td>Application type</td>
<td>Total No of App.</td>
</tr>
HT;

	$result ;

	if( count($dt) == 3 )
	{
		$result = countApplnOnDay( $user, $dt[2] , $dt[1] , $dt[0] );
	}
	else if( count($dt) == 2 )
	{
		$result = countApplnInMonth( $user , $dt[1] , $dt[0] );
	}
	else if( count($dt) == 1 )
	{
		$result = countApplnInYear( $user , $dt[0] );
	}
	else
	{
		echo "date format not correct. Date should be: yyyy OR yyyy-mm OR yyyy-mm-dd";
	}

	foreach( $result as $key => $value )
	{
		echo "<tr><th>$key</th><td>$value</td></tr>" ;
	}

}

echo "</table>";

?>
