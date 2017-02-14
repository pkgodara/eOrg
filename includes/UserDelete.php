<?php
/*
 *  remove user details and all data if required from database.
 */

session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && $_SESSION['Username'] == 'admin' ) )
{
	echo "session id :".session_id()." ,You need to login as Admin to remove users. Please log in as/contact Admin.";
	die();
}

if( isset( $_POST['user'] ) )
{
	$userN = $_POST['user'] ;

	if( isset( $_POST['removeData'] ) ) // remove all data for user
	{
	}
}
else
{
	echo "Please fill the details first.";
	die();
}


?>
