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

</head>

<body >

<h2>This Software require MySql access to create and maintain databases.<br/>If you have not installed it, Please do it now.</h2>

<h3>Please Enter MySql Database information.</h3>

<form action="includes/installer/MySqlInstaller.php" method="post">


<table border = "15">

<caption style ="color:blue;text-align:center"><h1><b>WELCOME</b></h1></CAPTION>
<tr><th>Database Client :</th> <td><input type="text" name="dbclient" value="mysql" required/></td></tr> 
<tr><th>Database Server :</th><td> <input type="text" name="dbserver" value="localhost:3306" required/> </td></tr>
<tr><th>Database Name   : </th><td><input type="text" name="dbname" value="eorgDB" required/></td> </tr>
<tr><th>MySql Username  :</th><td> <input type="text" name="mysqlUser" value="root" required/> </td></tr>
<tr><th>MySql Password  : </th><td><input type="password" name="mysqlPasswd" required/> </td></tr>

</table>

<input  type="submit" name="submit" value="Submit!" />
</form>
 
</body>
</html>
HTML;


	echo "$MySqlForm";
}

?>
