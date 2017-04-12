<?php
/*
 *
 * this is to modify the existing categories
 *
 */

session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && $_SESSION['Username'] === 'admin' ) )
{
	echo "To access this page you need to login as Admin. Please log in first.";
	die();
}


$html = <<<HTML
<form action="installer/addNewCat.php">
<button type="submit">Add a new category</button><br><br>
</form>
<form action="">
<button type="submit">Delete a category</button><br><br>
</form>

HTML;


echo $html;


?>
