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
	else if( isset( $_SESSION['PostName'] ) )
	{
		header("Location:includes/dashboard/PostDashBoard.php");
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
<link rel="shortcut icon" href="/favicon.png" type="image/png">
<link rel="shortcut icon" type="image/png" href="image/gogreen.jpg" />
<title>Login</title>
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

a:link    {color:black;  text-decoration:none}/*link color when not visited anytime*/
a:visited {color:white;  text-decoration:none}/*link coloe after visiting*/
a:hover   {color:red;  text-decoration:none}/*link color when try to click the link*/
a:active  {color:white; background-color:transparent; text-decoration:none}/*link color juat after clicking if active*/

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


<table style ="border-width:5px; border-style:double ;border-color:white ;padding: 8px;">

<caption style ="color:white;text-align:center"><h1><b>WELCOME</b></h1></CAPTION>
<tr><th style = "background-color:#b3003b ;color:white">Username  :</th><td> <input type="text" name="User" required autofocus/> </td></tr>
<tr><th style = "background-color:#b3003b ; color:white">Password  : </th><td><input type="password" name="Passwd" required/> </td></tr>

</table>
<br><br><br><br>
<input  type="submit" name="login" value="Login!" style="cursor: pointer; font-size : 30px; height:auto; width:auto ;background-color: 	transparent ;border:1px solid white;color:white" />
</form>
</centre>
<br><br><br>

<a href = "includes/AboutUs.php"><h1><b>ABOUT US</a>
</body>
</html>
HTML;

echo $html;


?>
