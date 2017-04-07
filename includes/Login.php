<?php
/* 
 * Generate Login page
 */
session_start();

if( isset( $_SESSION['Username'] ) )
{
	if( $_SESSION['Username'] == 'admin' )
	{
		header("Location:includes/dashboard/Admin.php");
	}
	else
	{
		header("Location:includes/dashboard/User.php");
	}
	die();
}

$html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<style>
body {
    
    background-image: url("nat.jpg");
}

</style>
<title>Login!</title>

</head>
<center>
<body>

<h2>Please Enter your Login credentials.</h2>

<form action="includes/dashboard/Dashboard.php" method="post">


<table border = "15">

<caption style ="color:blue;text-align:center"><h1><b>WELCOME</b></h1></CAPTION>
<tr><th>Username  :</th><td> <input type="text" name="User" required/> </td></tr>
<tr><th>Password  : </th><td><input type="password" name="Passwd" required/> </td></tr>

</table>
<br><br><br><br>
<input  type="submit" name="login" value="Login!" style=" font-size : 30px; height:auto; width:auto ;background-color: 	#000080 ;border:15px ;color:white" />
</form>
</centre>
</body>
</html>
HTML;

echo $html;


?>
