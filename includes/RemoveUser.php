<?php
/* 
 * allows admin to remove user.
 */

session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && ( $_SESSION['Username'] == 'admin' || isset($_SESSION['PostName']) ) ) )
{
	echo "session id :".session_id()." ,You need to login as Admin to change users. Please log in as/contact Admin.";
	die();
}

$html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<title>Remove User</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
a:link    {color:red;  text-decoration:none}/*link color when not visited anytime*/
a:visited {color:red;  text-decoration:none}/*link coloe after visiting*/
a:hover   {color:white;  text-decoration:none}/*link color when try to click the link*/
a:active  {color:red; background-color:transparent; text-decoration:none}/*link color juat after clicking if active*/

button,select
table,th,td{
	cursor: pointer; font-size : 25px; height:auto; width:auto ;background-color:#000000;color:white ;
	border: 0.25px solid white;
}
input[type=text]{
    
    width: 300px;
   height:35px;
  font-size:25px;
}
input[type=checkbox]{


 height:20px; width:20px;
}
body {
	
    font-size:30px;
    color:white;
    background-image: url("../image/image4.jpg");
     min-height: 500px;
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}
</style>
</head>
<body >
<center>
<br><br><br>
<button onclick="document.location.href='../'" > HOME</button><br>
<h2>Please Enter Credentials.</h2>

<form action="UserDelete.php" method="post">
<table border = "15">
<tr><th>Username :</th><td> <input type="text" name="user" required/> </td></tr>
<tr><th>Remove All Data for User:</th><td> <input type="checkbox" name="removeData"/> </td></tr>
</table>
<button type = "submit" >Remove User</button></form>
 
</body>
</html>
HTML;

echo $html;

?>
