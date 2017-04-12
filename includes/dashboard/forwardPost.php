<?php

/* 
 * intermediate dashboard for post
 */

session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) ) )
{
	echo "To access this page you need to login. Please log in first.";
	die();
}

if (! isset($_POST['post']))
{
	echo "Sorry, there is some problem";
	die();
}

$_SESSION['PostName'] = $_POST['post'];
//header("Location:PostDashBoard.php");


?>
