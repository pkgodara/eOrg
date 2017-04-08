<?php

/*****************************************************
 *
 * this file willl handle the option of user categrise.
 *
 *
 *
 ******************************************************/


session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && $_SESSION['Username'] == 'admin' ) )
{
	echo "session id :".session_id()." ,You need to login as Admin to add users. Please log in as/contact Admin.";
	die();
}

$TableName = $_REQUEST["q"];



require 'Globals.php';
require '../LocalSettings.php';


$sqlConn = new mysqli ( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $catDB );


if( $sqlConn->connect_errno ) 
{
	echo "Error connecting database. Please check your database credentials and update.";
	die();
}



$qry = "SELECT * FROM $TableName LIMIT 1 ";
$stmt = $sqlConn->prepare($qry);


$stmt->execute();

$result = $stmt->get_result();

$r = mysqli_fetch_row($result);


$levelStr = $r[0];
$newLevelStr = $levelStr."_[0-9]{1,}";

$table= $r[1];


$Str = str_replace('L','C',$levelStr) ;

$qry = "select * from $table where $levels regexp \"^$Str$\"";

$stmt = $sqlConn->prepare($qry);

$stmt->execute();

$result = $stmt->get_result();


if($result->num_rows == 0 )
{
	echo "<br><br><input type = 'radio' name = 'LastValue' value = $levelStr checked > ";
	echo "  Categorization is Complete now Submit the form";

}
else

{
	$row = mysqli_fetch_row($result);
	echo"<big><b>SELECT ".$row[1]." :::</big></b>  ";

	show_cat( $table , $newLevelStr );
}


function show_cat( $table , $newLevelStr  )
{

	global $sqlConn ;
	$sqlConn = $sqlConn ;
	global $levels;
	$levels = $levels;

	$qry = "select * from $table where $levels regexp \"^$newLevelStr$\" ";
	$stmt = $sqlConn->prepare($qry);

	$stmt->execute();

	$result = $stmt->get_result();

	echo"<select name = 'level'  id = $table onclick = 'FurtherCategorize( this.id ,this.value )'>";

	while ($r = mysqli_fetch_row($result))

	{
		echo "<option value= $r[0] >$r[1]</option>";
	}

}







?>
