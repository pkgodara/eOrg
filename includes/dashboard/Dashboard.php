<?php

/* 
 * Log-in the user.
 */

if(!( isset($_POST['User']) && isset( $_POST['Passwd'] ) ) )
{
	echo "Please fill the credentials.";
	die();
}

$user = $_POST['User'];
$passwd = $_POST['Passwd'];

require_once "../../LocalSettings.php";
require_once "../Globals.php";

$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $eorgDBname );

if( $sqlConn->connect_errno ) 
{
	echo "Internal Server Error, Contact Administrator.";
	die();
}

// get and check for credentials
$qry = "SELECT * FROM $loginDB WHERE $UName = ?" ;
$stmt = $sqlConn->prepare( $qry );
$stmt->bind_param('s',$user);
$stmt->execute();

$result = $stmt->get_result();
$row = mysqli_fetch_row($result);


// check password.
if( password_verify($passwd,$row[1]) ) //if password correct
{
	session_start();

	if( !isset( $_SESSION['Username'] ) || !isset($_SESSION['Name']) )
	{
		$_SESSION['Username'] = $user;
		$_SESSION['Name'] = $row[2];
	}

	$ipath = dirname( __DIR__ );

	if( $user == 'admin' )
	{
		//echo "you are admin ; id: " . session_id();
		require "$ipath/dashboard/Admin.php";
	}
	else
	{
		require "$ipath/dashboard/User.php";
	}
}
else
{
	echo "Incorrect credentials.";
	die();
}


?>
