<?php

/*********************************************************************************

this page is handling data after submiting from create post file



**********************************************************************************/
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
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
a:link    {color:red;  text-decoration:none}/*link color when not visited anytime*/
a:visited {color:red;  text-decoration:none}/*link coloe after visiting*/
a:hover   {color:white;  text-decoration:none}/*link color when try to click the link*/
a:active  {color:red; background-color:transparent; text-decoration:none}/*link color juat after clicking if active*/

body {
    
    background-image: url("../../image/image11.jpg");
     min-height: 500px;
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}
</style>
</head>

<body>
HTML;

echo $html;

require '../Globals.php';
require '../../LocalSettings.php';

if ($_SESSION['Username'] == 'admin')
{
echo "<a href = '../dashboard/Admin.php'><h1><b><i>HOME</i></b></h1></a>";
}
else
{
echo "<a href = '../dashboard/PostDashBoard.php'><h1><b><i>HOME</i></b></h1></a>";
}
echo "<br><br><a href = 'CreatePost.php'><h1><b><i>CREATE ANOTHER POST.</i></b></h1></a>";

if (  !(isset ($_POST['Pname']) &&  isset ($_POST['add_user']) && isset ($_POST['delete_user']) && isset ($_POST['assign_post']) && isset ($_POST['handle_post']) && isset ($_POST['accept_application']) && isset ($_POST['canAccessDatabase']) )  )
{

		echo "<br><br><h3 style = 'color:white ;'>Error IN creating Post Try Again.</h3>";
		die();

}


$userPost = str_replace('.','$',$_POST['Pname']) ;
$userPost = preg_replace('/\s+/', '_', $userPost);


if ($_POST['accept_application'] == "yes" )
{

	$CanAcceptArrey = array();
	$CanAcceptArrey = $_POST['canAccept'] ;

	if( ($length = count ($CanAcceptArrey)) != 0)
	{
		$finalString = "";
		for($i = 0 ; $i < $length - 1 ; $i++) 

		{
			$finalString = $finalString.$CanAcceptArrey[$i].";";
		}
			$finalString = $finalString.$CanAcceptArrey[$length - 1];
	}

	else
	{
		
		echo "<br><br><h3 style = 'color:white ;'>Error IN creating Post Try Again.</h3>";
		die();
	}
}

else
	$finalString = $_POST['accept_application'];

if (($_POST['canAccessDatabase']) == "yes" )
{

	$CanAccessArrey = array();
	$CanAccessArrey = $_POST['accessDataBase'] ;

	if( ($length = count ($CanAccessArrey)) != 0)
	{
		$finalString1 = "";

		for($i = 0 ; $i < $length - 1 ; $i++) 

		{
			$finalString1 = $finalString1.$CanAccessArrey[$i].",";
		}
			$finalString1 = $finalString1.$CanAccessArrey[$length - 1];
}
	else
	{
		echo "<br><br><h3 style = 'color:white ;'> Error IN creating Post Try Again.</h3>";
		die();
	}


}
else
	$finalString1 = $_POST['canAccessDatabase'] ;


$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $eorgDBname );

if( $sqlConn->connect_errno ) 
{
	echo "Server error.";
	die();
}

//creating table for post data 

$qry = "create  table if not exists $PostTable ( $NameOfThePost VARCHAR(50) NOT NULL, $CanAddUser VARCHAR(30) NOT NULL,$CanDeleteUser  VARCHAR(30) NOT NULL,$CanAssignPost VARCHAR(30) NOT NULL ,$CanHandlePost VARCHAR(30) NOT NULL ,$CanAcceptApplication  VARCHAR(1000) NOT NULL  ,$CanAccessDataBaseOfUser  VARCHAR(1000) NOT NULL ,INDEX idx2 USING BTREE($NameOfThePost) ) ";

$stmt = $sqlConn->prepare($qry);

if(!$stmt->execute())
	echo"table is not crated";

$post = $_POST['Pname'];
$qry = "SELECT * FROM $PostTable WHERE $NameOfThePost regexp \"^$post$\"";//checking if the post is already exists or no not

	$stmt = $sqlConn->prepare($qry);
	$stmt->execute();
	$result = $stmt->get_result();
	if($result->num_rows != 0)
	{
		echo "<br><br><h3 style = 'color:white ;'> $post Post  already exists .</h3>";
		die ();
	}


//creating table for post applications

$stmt = $sqlConn->prepare("CREATE TABLE IF NOT EXISTS $userPost ( $UserAppId BIGINT UNSIGNED NOT NULL, $UserAppTy VARCHAR(255), $AppDate VARCHAR(10) NOT NULL, INDEX idx USING BTREE($UserAppId), INDEX idx1 USING BTREE($UserAppTy) , INDEX idx2 USING BTREE($AppDate) )" );

	if( ! $stmt->execute() )
	{
		echo"<br><br><h3 style = 'color:white ;'>Error creating database for user, contact Admin</h3>";
		die();
	}
	





$qry = "insert into $PostTable values(? ,? ,? ,? ,? ,? ,?)";
$stmt = $sqlConn->prepare($qry);
$stmt->bind_param('sssssss' ,$_POST['Pname'], $_POST['add_user'], $_POST['delete_user'] , $_POST['assign_post'] , $_POST['handle_post'] ,$finalString , $finalString1);

if($stmt->execute())
{
	echo"<br><br><h3 style = 'color:white ;'>POST CREATED SUCCESSFULLY</h3>";
	die();
}	
else
{
	echo"<br><br><h3 style = 'color:white ;'>ERROR IN CREATING POST TRY AGAIN</h3>";
	die();
}

echo"</body></html>";
?>
