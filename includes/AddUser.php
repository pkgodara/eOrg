<?php

/* 
 * Admin can add users by this page.
 */
session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && $_SESSION['Username'] == 'admin' ) )
{
	echo "session id :".session_id()." ,You need to login as Admin to add users. Please log in as/contact Admin.";
	die();
}
require 'Globals.php';
require '../LocalSettings.php';

require 'option.php';

?>

