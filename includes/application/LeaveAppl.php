<?php

/* 
 * Leave application generation for users.
 *
 */

session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) ) )
{
	echo "session id :".session_id()." ,You need to login to generate leave applications. Please log in.";
	die();
}

$html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<title>Add User</title>

</head>

<body >

<h2>Please Enter Credentials.</h2>

<form action="../AppLeave.php" method="post">

<table border = "15">

<caption style ="color:blue;text-align:center"><h1><b>WELCOME</b></h1></CAPTION>
<tr><th>Leave Start Date :</th><td> <input type="text" name="from" required/> </td></tr>
<tr><th>Leave Till Date : </th><td><input type="text" name="upto" required/> </td></tr>
<tr><th>Reason : </th><td><input type="text" name="reason" required/> </td></tr>
<tr><th>Receiver User : </th><td><input type="text" name="dest" required/> </td></tr>
</table>

<input  type="submit" name="submit" value="Submit Application !" />
</form>
 
</body>
</html>
HTML;

echo $html;


?>
