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
<form  action="initCatDB.php" method="post">
<div id="afterClick">
<input type="text" name="levels[]" required="required" pattern='[A-Za-z0-9 ]{1,}' title='only alphabets, numbers and space are allowed'>
<button type="button" id="1" onclick="addAnother()" >Want to add another</button>
</div>
<br><button type='submit' name='submit'>Done with it !</button><br>
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
var i = 1;
function addAnother ()
{
//hiding the previous button
//
$("#"+i).hide();
i++;
//asking to add another or done with adding
//

$("#afterClick").append("<br><input type='text' name='levels[]' required='required' pattern='[A-Za-z0-9 ]{1,}' title='only alphabets, numbers and space are allowed'><button type='button' id='"+i+"' onclick='addAnother ()' >Want to add another</button>");
}
</script>
</body>
</html>
HTML;


echo $html;



?>
