<?php

/* 
 * AddUser.php posts data here.
 * backend for adding user.
 */

session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && $_SESSION['Username'] == 'admin' ) )
{
	echo "session id :".session_id()." ,You need to login as Admin to add users. Please log in as/contact Admin.";
	die();
}



if( isset($_POST['user']) && isset($_POST['passwd']) && isset($_POST['fname']) && isset($_POST['design']) )
{
	

require_once "../LocalSettings.php";
	require_once "Globals.php";

$a=',';



if($_POST['design'] == 'S')

{

if(isset($_POST['deg'] ) && isset($_POST['dcpln']) && isset($_POST['batch']) && ($_POST['dcpln'] != 'null') && ($_POST['deg'] != 'null') && ($_POST['batch'] != 'null') )
$design = $_POST['design'].$a.$_POST['deg'].$a.$_POST['dcpln'].$a.$_POST['batch'];
else
{
echo "Please fill the details first.";
	die();
}
}



else if(isset($_POST['OArnk']) && $_POST['OArnk'] == 'yes')
{
if(isset($_POST['dept'] ) && isset($_POST['Arnk']) && $_POST['dept'] != 'null' && $_POST['Arnk'] != 'null' && $_POST['OArank'] != 'null')

$design = $_POST['design'].$a.$_POST['dept'].$a.$_POST['Arnk'].';'.$_POST['design'].$a.$_POST['dept'].$a.$_POST['Arnk'].$a.$_POST['OArank'];
else
{
echo "Please fill the details first.";
	die();
}
}

else
{
if(isset($_POST['dept'] ) && isset($_POST['Arnk']) && isset($_POST['OArnk']) && $_POST['dept'] != 'null' && $_POST['Arnk'] != 'null')

$design =$_POST['design'].$a.$_POST['dept'].$a.$_POST['Arnk'];

else
{
echo "Please fill the details first.";
	die();
}
}



$user = $_POST['user'];

	if( ! preg_match('#^[A-Za-z0-9\.]+$#' , $user ) )
	{
		echo "Username not allowed";
		die();
	}

	$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $eorgDBname );

	if( $sqlConn->connect_errno ) 
	{
		echo "Server error.";
		die();
	}

	$hash = password_hash( $_POST['passwd'] , PASSWORD_BCRYPT );

	// insert login data into database
	//



	$stmt = $sqlConn->prepare("Insert INTO $loginDB VALUES ( ?,?,?,? )" );
	$stmt->bind_param('ssss',$_POST['user'],$hash,$_POST['fname'], $design );

	if( ! $stmt->execute() )
	{
		echo "Error updating database information, Try another username";
		die();
	}

	$stmt->close();

	// creating user database for storing owned applications
	// Since '.' is not allowed in name , using '$'
	$userdb = str_replace('.','$',$user) ;
	$stmt = $sqlConn->prepare("CREATE TABLE $userdb ( $UserAppId BIGINT UNSIGNED NOT NULL, $UserAppTy VARCHAR(5), PRIMARY KEY($UserAppId) )" );

	if( ! $stmt->execute() )
	{
		//echo "Error : $sqlConn->errno : $sqlConn->error <br>";
		echo "Error creating database for user, contact Admin";
		die();
	}

	$sqlConn->close();

	echo "user added successfully";
	die();
}
else
{
	echo "Please fill the details first.";
	die();
}

?>
