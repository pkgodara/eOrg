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


$table = $_REQUEST['q'];
$levelId= $_REQUEST['f'];






echo "<input  type = 'button' name =  '$table'  id = '$levelId'   value =  'FURTHER EXPLORE'   onclick= 'DocumentForCanAccessDatabaseOfUser_FurtherExplore(this.name ,this.id)' >";
echo "<input type ='button' name = '$levelId'  value = 'DONE'  onclick = 'DocumentForCanAccessDatabaseOfUser_Done(this.name)' >";

?>
