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

$done = $REQUEST['q'];


echo "<input  type = 'radio' name = 'Can_accept[]'  value =  '$done' checked>Complete<br>";
echo"Want to add another path";
echo "<input type ='radio' name = 'y' value = 'yes'  onclick = 'WhoseApplication()' > Yes";
echo "<input type ='radio' name = 'y' value = 'no'> NO ";




?>
