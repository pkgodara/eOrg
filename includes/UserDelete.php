<?php
/*
 *  remove user details and all data if required from database.
 */

session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && ( $_SESSION['Username'] == 'admin' || isset($_SESSION['PostName']) ) ) )
{
	echo "session id :".session_id()." ,You need to login as Admin to add users. Please log in as/contact Admin.";
	die();
}

$html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<title>Remove User</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
a:link    {color:red;  text-decoration:none}/*link color when not visited anytime*/
a:visited {color:red;  text-decoration:none}/*link coloe after visiting*/
a:hover   {color:white;  text-decoration:none}/*link color when try to click the link*/
a:active  {color:red; background-color:transparent; text-decoration:none}/*link color juat after clicking if active*/

body {
	
    font-size:30px;
    color:white;
    background-image: url("../image/image4.jpg");
     min-height: 500px;
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}
</style>
</head>
<body >
<br><br><br>
HTML;
echo $html;
if ($_SESSION['Username'] == 'admin')
{
echo "<br><br><a href = 'dashboard/Admin.php'>HOME</a><br>";
}
else
{
echo "<a href = 'dashboard/PostDashBoard.php'><h2><b><i>HOME</i></b></h2></a>";
}
echo "<a href = 'RemoveUser.php'>Delete another user.</a><br><center>";


if( isset( $_POST['user'] ) )
{
	require_once "../LocalSettings.php";
	require_once "Globals.php";
	
	$userN = $_POST['user'] ;
	
	if($userN == "admin")
	{
	
	echo "YOU CAN'T DELETE ADMIN<br><br>";
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
		die ();
	}
else
{
$qry = "DELETE FROM $loginDB WHERE $UName = ?" ;
	$stmt = $sqlConn->prepare ( $qry );
	$stmt->bind_param ( 's', $userN );
	
	
	if (  $stmt->execute() )
	{
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
	die ();
}

echo "</center></body></html>";
?>
