<?php

/* 
 *  delete a post
 */



session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && $_SESSION['Username'] === 'admin' ) )
{
	echo "To access this page you need to login as Admin. Please log in first.";
	die();
}


$html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="/favicon.png" type="image/png">
<link rel="shortcut icon" type="image/png" href="../../image/gogreen.jpg" />
<style>
a:link    {color:red;  text-decoration:none}/*link color when not visited anytime*/
a:visited {color:red;  text-decoration:none}/*link coloe after visiting*/
a:hover   {color:white;  text-decoration:none}/*link color when try to click the link*/
a:active  {color:red; background-color:transparent; text-decoration:none}/*link color juat after clicking if active*/

body {
    
    background-image: url("../../image/image4.jpg");
     min-height: 500px;
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}
button
{
	cursor: pointer; font-size : 25px; height:auto; width:auto ;background-color:transparent;color:white ;
	border: 0.25px solid white;
}
</style>
</head>

<body>
<br><br>
<button onclick="document.location.href='../../'"> BACK </button>
<center>
<br><br><br><br><br><br><br>
<form action = "DeletePost.php" method = "post">
<var style ="color:white"><b><i>Type the name of POST::</i></b></var>
<input type = "text" name = "delete" pattern='[A-Za-z0-9. ]{1,}'  title='only alphabets, numbers and spaces and dot are allowed' required autofocus>
<br><br>
<button type = "submit"  >DELETE</button>
</form>

HTML;
echo $html;

if ( isset($_POST['delete']))

	DeletePost ( $_POST['delete'] );

function DeletePost ( $DeleteThisPost)
{
	require '../Globals.php';
	require '../../LocalSettings.php';

	$userN = $DeleteThisPost;
	$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $eorgDBname );

	if( $sqlConn->connect_errno ) 
	{
		echo "Server error.";
		die();
	}

	$qry = "DELETE FROM $PostTable WHERE  $NameOfThePost = ?" ;
	$stmt = $sqlConn->prepare ( $qry );
	$stmt->bind_param ( 's', $DeleteThisPost );


	if (  $stmt->execute() )
	{
		$DeleteThisPost = str_replace('.','$', $DeleteThisPost);
		$DeleteThisPost = preg_replace('/\s+/', '_', $DeleteThisPost);
		$stmt = $sqlConn->prepare ( "DROP TABLE $DeleteThisPost");

		$stmt->execute();
		
		$stmt = $sqlConn->prepare ("DELETE FROM $assignPostTable WHERE $postTitle REGEXP \"^$userN$\"");
		
		if ( ! $stmt->execute() )
		{
			echo "there is a problem with database<br>";
			die ();
		}
		$stmt->close();

		echo "<br><br><h1 style = 'color:white'><b><i>POST $userN has been successfully deleted.</b></i></h1>";
		echo "<br><br><a href = 'DeletePost.php'><h1>Delete another user.</h1></a>";
		die();
	}
	else
	{
		echo "<h1 style = 'color:white'><b><i>ERROR IN DELETE POST TRY AGAIN!!</b></i></h1>";
		echo "<br><br><a href = 'DeletePost.php'><h1>Delete another user.</h1></a>";
		die(); 
	}
	$stmt->close();

	echo"</body></html>";
}
?>
