<?php
/* 
 * allows admin to remove user.
 */

session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && $_SESSION['Username'] == 'admin' ) )
{
			echo "session id :".session_id()." ,You need to login as Admin to change users. Please log in as/contact Admin.";
						die();
}

$html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<title>Remove User</title>

</head>

<body >

<h2>Please Enter Credentials.</h2>

<form action="UserDelete.php" method="post">


<table border = "15">

<caption style ="color:blue;text-align:center"><h1><b>WELCOME</b></h1></CAPTION>
<tr><th>Username :</th><td> <input type="text" name="user" required/> </td></tr>
<tr><th>Remove All Data for User:</th><td> <input type="checkbox" name="removeData"/> </td></tr>
</table>

<input  type="submit" name="submit" value="Remove User !" />
</form>
 
</body>
</html>
HTML;

echo $html;

?>
