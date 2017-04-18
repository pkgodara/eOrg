<?php

// check for database & admin-user and create if not
//
$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $eorgDBname );

if( $sqlConn->connect_errno ) 
{
	echo "Error connecting database. Please check your database credentials and update.";
	die();
}


$html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<title>Admin Login</title>
<link rel="shortcut icon" href="/favicon.png" type="image/png">
<link rel="shortcut icon" type="image/png" href="image/gogreen.jpg" />
<title>Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
    
    background-image: url("image/image11.jpg");
color:white;
font-size:25px;
     padding:100px;
     min-height: 500px;
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}

input[type=submit]
{
	cursor: pointer; font-size : 25px; height:auto; width:auto ;background-color:transparent;color:white ;
	border: 0.25px solid white;
}

</style>
</head>

<body ><center>

<h2>Please Enter Admin Credentials.</h2>

<form action="includes/installer/InitDB.php" method="post">


<table border = "15">
<center>

<tr><th>Admin Username  :</th><td> <input type="text" name="Admin" value="admin" readonly required/> </td></tr>
<tr><th>Admin Password  : </th><td><input type="password" name="AdminPasswd" required/> </td></tr>

</table>
<br><br><br><br><br><br>
<input  type="submit" name="submit" value="Submit!" />
</form>
</center>
</body>
</html>
HTML;

// check for admin
//

$qry = "SELECT $UName FROM $loginDB WHERE $UName = 'admin' ";

$stmt = $sqlConn->prepare($qry);

if( $sqlConn->errno == '1146' ) //table doesn't exist
{
	echo $html;
	die();
}
else
{
	$stmt->execute();

	$result = $stmt->get_result();
	$row = mysqli_fetch_row($result);

	if( $row[0] !== 'admin' ) // admin not set ; do it and create tables.
	{
		echo $html;
		die();
	}

	$stmt->close();
}
$sqlConn->close();

?>
