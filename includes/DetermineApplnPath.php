<?php

/* 
 * generate and initiate processing for application.
 *
 */

session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) ) )
{
	echo "You need to login to generate leave applications. Please log in.";
	die();
}



$stmt2 = $sqlConn->prepare("SELECT $UName FROM $loginDB WHERE ");


?>
