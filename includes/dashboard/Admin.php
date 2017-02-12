<?php

/* 
 * dashboard for admin
 */
if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && $_SESSION['Username'] === 'admin' ) )
{
	echo "you are not logged in. Please log in first.";
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

<button onclick="document.location.href='../AddUser.php'"> Add User </button>

<button onclick="document.location.href='../Logout.php'"> Log out ! </button>

</body>
</html>
HTML;

echo $html1;
echo " ".$_SESSION['Name'];
echo $html2;

?>
