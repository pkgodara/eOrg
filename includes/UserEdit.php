
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

	require_once "../LocalSettings.php";
	require_once "Globals.php";



	$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $eorgDBname );

	if( $sqlConn->connect_errno ) 
	{
		echo "Server error.";
		die();
	}


	//	$sql = "SELECT * FROM $loginDB WHERE $UName = $userN";
	$sql = "SELECT * FROM $loginDB WHERE $UName = ?" ;
	$stmt = $sqlConn->prepare( $sql );
	$stmt->bind_param('s',$userN);
	$stmt->execute();

	$result = $stmt->get_result();
	//	$row = mysqli_fetch_row($result);

	if(  $row = mysqli_fetch_row($result) )
	{

		$change = <<<HTML
<!DOCTYPE html >
<html>
<head>
<style> 
table{
margin-left:auto;
margin-right:auto;
background-color:blue;
}

</style>
</head>
<body >
<h1 style ="text-align:center ;color:blue">Edit The Information</h1>
<div >
<form action ="UpdateUser.php" method="post" >
<table border="12">
<tr><th>UserName </th><td> <input type = "text" name = "name" value = "$row[0]" readonly /></td></tr>
<tr><th>FullName </th><td> <input type="text" name = "flname" value="$row[2]"  required />    </td></tr>
<tr><th>Designations </th><td> <input type="text" name = "dgname" value= "$row[3]" required/> </td></tr>
</table>
<input type ="submit" name ="submit" value="UPDATE"/>
</form></div>
</body>
</html>
HTML;
	}
	else
	{
		echo "No user found" ;
		die();
	}


	echo $change ;


	
}

else
{
	echo "Please fill the details first.";
	die();
}


?>
