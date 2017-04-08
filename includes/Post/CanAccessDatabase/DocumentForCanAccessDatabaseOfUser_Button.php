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

require '../../Globals.php';
require '../../../LocalSettings.php';


$TableName = $_REQUEST["q"];

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

$table= $r[1];


$Str = str_replace('L','C',$levelStr) ;

$qry = "select * from $table where $levels regexp \"^$Str$\"";

$stmt = $sqlConn->prepare($qry);

$stmt->execute();

$result = $stmt->get_result();


if($result->num_rows == 0 )
{
echo "<b><big>Categorization is complete for this level</big></b>";
//echo "<br><input type = 'button' name = '$levelStr' value ='DONE'  onclick = 'Done(this.name )' > ";
echo"Want to add another path";
echo "<input type ='radio' name = 'y' value = '$levelStr'  onclick = 'DocumentForCanAccessDatabaseOfUser_newPath(this.value)' > Yes";
echo "<input type ='radio' name = 'y' value = '$levelStr' onclick = 'DocumentForCanAccessDatabaseOfUser_terminate(this.value)' > NO ";

}


else

{

echo "<button type='button' name =  '$TableName' id ='1' value =  '$levelStr'   onclick= 'DocumentForCanAccessDatabaseOfUser_FurtherExplore(this.name ,this.value)' >  FURTHER EXPLORE </button>";
echo "<input type ='button' name = '$levelStr' value = 'DONE'  onclick = 'DocumentForCanAccessDatabaseOfUser_Done(this.name)' >";

}

























?>
