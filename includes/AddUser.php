<?php

/* 
 * Admin can add users by this page.
 */
session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && $_SESSION['Username'] == 'admin' ) )
{
	echo "session id :".session_id()." ,You need to login as Admin to add users. Please log in as/contact Admin.";
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

<form action="UserAdd.php" method="post">


<table border = "15">

<caption style ="color:blue;text-align:center"><h1><b>WELCOME</b></h1></CAPTION>
<tr><th>Username :</th><td> <input type="text" name="user" required/> </td></tr>
<tr><th>Password : </th><td><input type="text" name="passwd" required/> </td></tr>
<tr><th>Full Name : </th><td><input type="text" name="fname" required/> </td></tr>
<tr><th>Designations : </th><td><input type="text" name="design" required/> </td></tr>

</table>

<input  type="submit" name="submit" value="Create User !" />
</form>
 
</body>
</html>
HTML;

echo $html;

?>
