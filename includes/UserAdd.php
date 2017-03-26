<?php

/* 
 * AddUser.php posts data here.
 * backend for adding user.
 *
 */

session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && $_SESSION['Username'] == 'admin' ) )
{
	echo "session id :".session_id()." ,You need to login as Admin to add users. Please log in as/contact Admin.";
	die();
}



if( isset($_POST['user']) && isset($_POST['passwd']) && isset($_POST['fname']) && isset($_POST['LastValue'])  && isset($_POST['sex']) )
{


	require_once "../LocalSettings.php";
	require_once "Globals.php";
	require_once "StringManuplation.php";	
	
	$String = $_POST['LastValue'];
	
	$design = StringManuplation( $String );//finding final designation name



	$user = $_POST['user'];


	// Validate username : only A-Z and a-z and 0-9 and . is allowed.
	if( ! preg_match('#^[A-Za-z0-9\.]+$#' , $user ) )
	{
		echo "Username not allowed";
		die();
	}

	// SQL DB connection
	//
	$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $eorgDBname );

	if( $sqlConn->connect_errno ) 
	{
		echo "Server error.";
		die();
	}

	$hash = password_hash( $_POST['passwd'] , PASSWORD_BCRYPT );



	// insert login data into database
	//
	$stmt = $sqlConn->prepare("Insert INTO $loginDB VALUES ( ?,?,?,?,? )" );
	$stmt->bind_param('sssss',$_POST['user'],$hash,$_POST['fname'],$_POST['sex'],$design );

	if( ! $stmt->execute() )
	{
		echo "<h1 style ='color:red'>Error updating database information, Try another username because same user name already exists</h1>";
		echo "<br><br><h3><a href = 'AddUser.php'>Add Another User</a>";
		echo "<br><a href = 'dashboard/Admin.php'>HOME</a></h3>";
		die();
	}

	$stmt->close();


	// update designation tree in Database;
	//
	$posts = explode(';',$design);
	
	// update record for each designation.
	//
	foreach( $posts as $post )
	{
		$stmt = $sqlConn->prepare("INSERT INTO $DesigDB VALUES (?,?)");
		$stmt->bind_param('ss', $post , $user );

		if( ! $stmt->execute() )
		{
			echo "Error updating designations.";
			die();
		}
	}


	// creating user database for storing owned applications
	// Since '.' is not allowed in name , using '$'
	//
	$userdb = str_replace('.','$',$user) ;
	$stmt = $sqlConn->prepare("CREATE TABLE $userdb ( $UserAppId BIGINT UNSIGNED NOT NULL, $UserAppTy VARCHAR(5), PRIMARY KEY($UserAppId) )" );

	if( ! $stmt->execute() )
	{
		//echo "Error : $sqlConn->errno : $sqlConn->error <br>";
		echo "Error creating database for user, contact Admin";
		die();
	}

	$sqlConn->close();

	echo "<h2>User Added Successfully";
	echo"<br><br><a href = 'AddUser.php'>CREAT ANOTHER USER</a> <br> <a href = '../'>HOME</a><br>";
	die();
}
else
{
	echo "Please fill the details first.";
	die();
}

?>
