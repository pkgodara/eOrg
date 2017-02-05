<?php

/*
 * Checking and getting necessary information for database.
 */


function form() {

	$MySqlForm = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<title>MySql Database settings</title>
</head>

<body>
<h2>This Software require MySql access to create and maintain databases.<br/>If you have not installed it, Please do it now.</h2>
<h3>Please Enter MySql Database information.</h3>

<form action="includes/installer/MySqlInstaller.php" method="post">
Database Client : <input type="text" name="dbclient" value="mysql"/> <br/>
Database Server : <input type="text" name="dbserver" value="localhost:3306" /> <br/>
Database Name   : <input type="text" name="dbname" value="eorgDB" /> <br/>
MySql Username  : <input type="text" name="mysqlUser" value="root" /> <br/>
MySql Password  : <input type="password" name="mysqlPasswd" /> <br/>
<input type="submit" name="submit" value="Submit!" />
</form>
 
</body>
</html>
HTML;


	echo "$MySqlForm";
}

?>
