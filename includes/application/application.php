<?php
/* 
 * handle ajax
 *
 * display form for generating application
 *
 */

$type = $_REQUEST['appln'];

if( $type != "" ) 
{
require '../Globals.php';
require '../../LocalSettings.php';


$sqlConn = new mysqli ( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $applnDB );

if( $sqlConn->connect_errno ) 
{
	echo "Error connecting database. Please check your database credentials and update.";
	die();
}

$res = $sqlConn->query("SELECT * FROM $type");

$flagSD = false;
$flagED = false;
$html ;

while( $row = $res->fetch_row() )
{
	$name = str_replace(' ','_',$row[0]);
	if( $row[0] == "Start Date" )
	{
		$flagSD = true;
		//echo "<tr><th>$row[0] :</th><td> <input type=\"text\" name=\"$name\" placeholder=\"Date yyyy-mm-dd\" required/></td></tr>";
	}
	else if ( $row[0] == "End Date" )
	{
		$flagED = true;
	}
	else
	{
		$html = $html."<tr><th>$row[0] :</th><td> <input type=\"text\" name=\"$name\" required/></td></tr>";
	}
}

if( $flagSD )
	echo "<tr><th>Start Date :</th><td> <input type=\"date\" name=Start_Date placeholder=\"Date yyyy-mm-dd\" required/></td></tr>";

if( $flagED )
	echo "<tr><th>End Date :</th><td> <input type=\"date\" name=End_Date placeholder=\"Date yyyy-mm-dd\" required/></td></tr>";


echo $html; 

}

?>
