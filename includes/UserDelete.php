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
	require_once "../LocalSettings.php";
	require_once "Globals.php";
	
	$userN = $_POST['user'] ;
	
	if($userN == "admin")
	{
	
	echo "YOU CAN'T DELETE ADMIN<br><br>";
	echo "<a href = 'RemoveUser.php'>Delete another user.</a>";
	echo "<br><br><a href = 'dashboard/Admin.php'>HOME</a>";
	die ();
	
	}

else
{
	$sqlConn = new mysqli ( $eorgDBserver, $eorgDBuser, $eorgDBpasswd, $eorgDBname );
	if ( $sqlConn->connect_errno )
	{
		echo "Server Error.";
		die ();
	}

$qry = "SELECT * FROM $loginDB where $UName regexp \"^$userN$\"";

	$stmt = $sqlConn->prepare($qry);
	$stmt->execute();
	$result = $stmt->get_result();
	if($result->num_rows == 0)
	{
		echo "User $userN does not exists.";
		echo "<br><br><a href = 'RemoveUser.php'>Delete another user.</a>";
		echo "<br><br><a href = 'dashboard/Admin.php'>HOME</a>";
		die ();
	}
else
{
$qry = "DELETE FROM $loginDB WHERE $UName = ?" ;
	$stmt = $sqlConn->prepare ( $qry );
	$stmt->bind_param ( 's', $userN );
	
	
	if (  $stmt->execute() )
	{
	 	
		echo "<br><br><a href = 'RemoveUser.php'>Delete another user.</a>";
		echo "<br><br><a href = 'dashboard/Admin.php'>HOME</a>";
		echo "<br><br>user $userN has been successfully deleted";
	}
	$stmt->close();

	if( isset( $_POST['removeData'] ) ) // remove all data for user
	{
		$user = str_replace('.','$',$userN);
		$stmt = $sqlConn->prepare ( "DROP TABLE $user");
		if ( $stmt->execute() )
		{
			echo " And the complete data of user $userN is successfully deleted also.";
			
			die ();
		}
		$stmt->close();
	}
	$sqlConn->close();
}
}
}
else
{
	echo "Please fill the details first.";
	echo "<br><br><a href = 'RemoveUser.php'>Delete another user.</a>";
	echo "<br><br><a href = 'dashboard/Admin.php'>HOME</a>";
	die ();
}


?>
