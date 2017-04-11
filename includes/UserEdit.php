
<?php
/*
 * generate html page with info from database to edit user details.
 *
 * EditUser.php posts data here.
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
<body style = "background-color:#FCFCE8">
<h1 style ="text-align:center ;color:blue">Edit The Information</h1>
<div >
<form action ="UpdateUser.php" method="post" >
<table border="12">
<tr><th>UserName </th><td> <input type = "text" name = "name" value = "$row[0]" readonly /></td></tr>
<tr><th>FullName </th><td> <input type="text" name = "flname" value="$row[2]"  required />    </td></tr>

</table>
<center><br><br>
SEX::<select name ='sex' required   style='cursor: pointer; height:auto; width:auto ;background-color:#4B0082;color:white' >
<option value ="">Select sex</option>
<option value ="Others">Other</option>
<option value ="Male">Male</option>
<option value ="Female">Female</option>
</select><br><br><br><br><br><br><br><br><br><br>
<input type ="submit" name ="submit" value="UPDATE" style='font-size:auto ;cursor: pointer; height:50px; width:200px;color:white ;background-color:#4B0082'/>
</center>
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
