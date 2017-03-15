<?php
/*
 *
 * This is to bradly categorise the users
 *
 */

session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && $_SESSION['Username'] === 'admin' ) )
{
	echo "To access this page you need to login as Admin. Please log in first.";
	die();
}




$html = <<<HTML
<html>
<head>
<title>Broad Categorise</title>
</head>
<body>
<p>Enter the categories</p>
<form id="afterClick" action="initCatDB.php" method="post">
<input type="text" name="levels[]" required="required">
<button type="button" onclick="addAnother()" >Add to users</button>
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
function addAnother ()
{
//asking to add another or done with adding
//
$("#afterClick").append("<br><button type='button' onclick='takeInput ()'>Want to Add another</button><br><button type='submit' name='submit'>Done with it !</button><br>");
}
function takeInput ()
{
//taking input if the user prompted to add another
//
$("#afterClick").append("<br><input type='text' name='levels[]' required='required'><button type='button' onclick='addAnother ()' >Add to users</button><br>");
}
</script>
</body>
</html>
HTML;


echo $html;



?>
