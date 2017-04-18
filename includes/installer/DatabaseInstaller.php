<?php

/*
 * Checking and getting necessary information for database.
 */


function form() {

	$MySqlForm = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<title>MySql Database settings</title>
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

<body >
<center>
<h2>This Software require MySql access to create and maintain databases.<br/>If you have not installed it, Please do it now.</h2>

<h3>Please Enter MySql Database information.</h3>

<form action="includes/installer/MySqlInstaller.php" method="post">


<table border = "15">


<tr><th>Database Client :</th> <td><input type="text" name="dbclient" value="mysql" readonly required/></td></tr> 
<tr><th>Database Server :</th><td> <input type="text" name="dbserver" value="localhost:3306" required/> </td></tr>
<tr><th>Database Name   : </th><td><input type="text" name="dbname" value="eorgDB" required/></td> </tr>
<tr><th>MySql Username  :</th><td> <input type="text" name="mysqlUser" value="root" required/> </td></tr>
<tr><th>MySql Password  : </th><td><input type="password" name="mysqlPasswd" required autofocus/> </td></tr>

</table>
<br><br><br><br><br><br><br>
<input  type="submit" name="submit" value="Submit!" />
</form>
 
</body>
</html>
HTML;


	echo "$MySqlForm";
}

?>
