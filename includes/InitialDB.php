<?php

// check for database & admin-user and create if not
//
$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $eorgDBname );

if( $sqlConn->connect_errno ) 
{
	echo "Error connecting database. Please check your database credentials and update.";
	die();
}

// check for admin
//
$stmt = $sqlConn->prepare( "SELECT $UName FROM $loginDB WHERE $UName = 'admin' " );

$stmt->execute();
$result = $stmt->get_result();
$row = mysqli_fetch_row($result);


if( $row[0] != 'admin' ) // admin not set ; do it and create tables.
{
	$html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<title>Admin Login</title>

</head>

<body >

<h2>Please Enter Admin Credentials.</h2>

<form action="includes/installer/InitDB.php" method="post">


<table border = "15">

<caption style ="color:blue;text-align:center"><h1><b>WELCOME</b></h1></CAPTION>
<tr><th>Admin Username  :</th><td> <input type="text" name="Admin" value="admin" readonly required/> </td></tr>
<tr><th>Admin Password  : </th><td><input type="password" name="AdminPasswd" required/> </td></tr>

</table>

<input  type="submit" name="submit" value="Submit!" />
</form>
 
</body>
</html>
HTML;

	echo $html;
}

$stmt->close();
$sqlConn->close();

?>
