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
<meta name="viewport" content="width=device-width, initial-scale=.5">
<style>


body {
    
    background-image: url("image/nat.jpg");
     min-height: 500px;
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}

</style>
<title>Login!</title>

</head>

<body>

HTML;
echo $html;
include 'dashboard/Watch.php';
$html = <<<HTML
<center>
<h2 style ="font-size:50px;color:white">Please Enter your Login credentials.</h2>

<form action="includes/dashboard/Dashboard.php" method="post">


<table border = "15">

<caption style ="color:white;text-align:center"><h1><b>WELCOME</b></h1></CAPTION>
<tr><th style = "background-color:#b3003b ;color:white">Username  :</th><td> <input type="text" name="User" required/> </td></tr>
<tr><th style = "background-color:#b3003b ; color:white">Password  : </th><td><input type="password" name="Passwd" required/> </td></tr>

</table>
<br><br><br><br>
<input  type="submit" name="login" value="Login!" style="cursor: pointer; font-size : 30px; height:auto; width:auto ;background-color: 	#000080 ;border:15px ;color:white" />
</form>
</centre>
</body>
</html>
HTML;

echo $html;


?>
