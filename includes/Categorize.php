<?php

/*******************************
 *
 * this file willl handle the option of user categrise.
 *
 *
 *
 ********************************/


session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && $_SESSION['Username'] == 'admin' ) )
{
	echo "session id :".session_id()." ,You need to login as Admin to add users. Please log in as/contact Admin.";
	die();
}


$TableName = $_REQUEST['q'];
$LevelStr =  $_REQUEST['f'];

$newLevelStr = $LevelStr."_[0-9]{1,}";

require 'Globals.php';
require '../LocalSettings.php';


$sqlConn = new mysqli ( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $catDB );


if( $sqlConn->connect_errno ) 
{
	echo "Error connecting database. Please check your database credentials and update.";
	die();
}


$table = $TableName ;



$Str = str_replace('L','C',$LevelStr) ;

$qry = "select * from $table where $levels regexp \"^$Str$\"";

$stmt = $sqlConn->prepare($qry);

if( !$stmt->execute())
{
	echo"problem in execution!!!";
	die();
}


$result = $stmt->get_result();

if($result->num_rows == 0 )

{

	echo "<br><input type = 'radio' name ='LastValue' value = $LevelStr checked > ";
	echo "<b><big>Categorization is complete now Submit</big></b>";

}

else

{

	$row = mysqli_fetch_row($result);

	echo"SELECT ".$row[1]." ::    ";


	show_cate( $table ,$newLevelStr  );
}
function show_cate( $table ,$newLevelStr )
{
	global $sqlConn ;


	$sqlConn = $sqlConn ;

	global $levels;
	$levels = $levels;

	$qry = "select * from $table where $levels regexp \"^$newLevelStr$\" ";

	$stmt = $sqlConn->prepare($qry);

	$stmt->execute();

	$result = $stmt->get_result();


	echo "<select name = 'level' id = $table  onclick = 'FurtherCategorize( this.id ,this.value )' >";
	//echo "<option value= "" ></option>";
	while ($r = mysqli_fetch_row($result))

	{
		echo "<option value= $r[0]  >$r[1]</option>";
	}
	echo"</select>";
}


?>
