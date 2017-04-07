<?php

/********************************************

this file will find out user from table for creat post

*********************************************/
session_start();


if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && $_SESSION['Username'] == 'admin' ) )

{
	echo "session id :".session_id()." ,You need to login as Admin to add users. Please log in as/contact Admin.";
	die();
}

else 
{


echo "yha per uska dena hi";




}


require '../Globals.php';
require '../../LocalSettings.php';


$TableName = $_REQUEST['q'];
$LevelStr =  $_REQUEST['f'];




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


echo "<b><big>Categorization is complete for this level now Done it</big></b>";

}


else

{

$row = mysqli_fetch_row($result);

//echo"SELECT ".$row[1]." ::    ";


show_cate( $table , $LevelStr  );
}


function show_cate( $table , $LevelStr  )
{
global $sqlConn ;


$sqlConn = $sqlConn ;

global $levels;
 $levels = $levels;

$qry = "select * from $table where $levels regexp \"^$LevelStr.$\" ";

$stmt = $sqlConn->prepare($qry);

$stmt->execute();

$result = $stmt->get_result();


echo "<select name = 'level' id = '$table'  onclick = 'button1( this.id ,this.value )' >";
//echo "<option value= "" ></option>";
while ($r = mysqli_fetch_row($result))

                {
                echo "<option value= $r[0]  >$r[1]</option>";
		}
echo"</select>";
}

?>


















