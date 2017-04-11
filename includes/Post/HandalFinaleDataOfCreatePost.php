<?php

/*********************************************************************************

this page is handling data after submiting from create post file



**********************************************************************************/
session_start();



if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && $_SESSION['Username'] == 'admin' ) )

{
	echo "session id :".session_id()." ,You need to login as Admin to add users. Please log in as/contact Admin.";
	die();
}

else 
{


	echo "yha per uska dena hi";




}


require '../Globals.php';
require '../../LocalSettings.php';


if (  !(isset ($_POST['Pname']) &&  isset ($_POST['add_user']) && isset ($_POST['delete_user']) && isset ($_POST['assign_post']) && isset ($_POST['handle_post']) && isset ($_POST['accept_application']) && isset ($_POST['canAccessDatabase']) )  )
{

	echo "Error IN creating Post Try Again";
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
		echo "Error IN creating Post Try Again";
		die();
	}


}
else
{

	$finalString = $_POST['accept_application'];

}




if (($_POST['canAccessDatabase']) == "yes" )
{

	$CanAccessArrey = array();
	$CanAccessArrey = $_POST['accessDataBase'] ;

/*foreach($CanAccessArrey  as $a )
{
echo $a."<br>";
}
}
 */
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
		echo "Error IN creating Post Try Again hjhj";
		die();
	}


}
else
{
	$finalString1 = $_POST['canAccessDatabase'] ;
}

//echo $finalString."  and  ". $finalString1;



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



/*

$qry = "SELECT * FROM $eorgDBname where $NameOfThePost regexp \"^$_POST['Pname']$\"";

	$stmt = $sqlConn->prepare($qry);
	$stmt->execute();
	$result = $stmt->get_result();
	if($result->num_rows != 0)
	{
		echo " $_POST['Pname'] Post  already exists .";
		//echo "<br><br><a href = '../dashboard/.php'>HOME</a>";
		//echo "<br><br><a href = 'dashboard/Admin.php'>CREATE ANOTHER POST</a>";
		die ();
	}




*/
//

//creating table for post dash board

$stmt = $sqlConn->prepare("CREATE TABLE IF NOT EXISTS $userPost ( $UserAppId BIGINT UNSIGNED NOT NULL, $UserAppTy VARCHAR(255), INDEX idx USING BTREE($UserAppId), INDEX idx1 USING BTREE($UserAppTy) )" );

	if( ! $stmt->execute() )
	{
		//echo "Error : $sqlConn->errno : $sqlConn->error <br>";
		echo "Error creating database for user, contact Admin";
		die();
	}
	





$qry = "insert into $PostTable values(? ,? ,? ,? ,? ,? ,?)";

$stmt = $sqlConn->prepare($qry);


$stmt->bind_param('sssssss' ,$_POST['Pname'], $_POST['add_user'], $_POST['delete_user'] , $_POST['assign_post'] , $_POST['handle_post'] ,$finalString , $finalString1);

if($stmt->execute())
{
	echo"POST CREATED SUCCESSFULLY";
	die();

}	
else
{
	echo "ERROR IN CREATING POST TRY AGAIN";
	die();
}



?>
