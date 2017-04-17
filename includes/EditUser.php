<?php

/* 
 * generates form to get username to edit details for.
 * Allows admin to edit user details.
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
<title>Edit User</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="/favicon.png" type="image/png">
<link rel="shortcut icon" type="image/png" href="../image/gogreen.jpg" />
<style>

button
{
	cursor: pointer; font-size : 25px; height:auto; width:auto ;background-color:#000000;color:white ;
	border: 0.25px solid white;
}
input[type=text]{
    
    width: 170px;
   height:25px;
  font-size:20px;
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

</head>

<body>
<center>
<br><br><br>
<button onclick="document.location.href='../'" > HOME</button><br><br>
<h2>Please Enter Credentials.</h2>

<form action="UserEdit.php" method="post">

Username :<input type="text" name="user" required autofocus>
<br><br>
<button type = "submit" >Edit User</button>
</form>
 
</body>
</html>
HTML;

echo $html;

?>
