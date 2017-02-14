<?php

/* 
 * dashboard for user
 */

session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) ) )
{
	echo "To access this page you need to login. Please log in first.";
	die();
}

$html1 = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<title>Admin</title>

</head>

<body >

<h2>Hello
HTML;

$html2 = <<<HTML
</h2>

<button onclick="document.location.href='../application/LeaveAppl.php'"> Generate Leave Application </button>

<button onclick="document.location.href='../Logout.php'"> Log out ! </button>

</body>
</html>
HTML;

echo $html1;
echo " ".$_SESSION['Name'];
echo $html2;

?>
