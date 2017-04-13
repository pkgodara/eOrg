<?php
/*
 *
 * This is to create application type.
 *
 */


session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && $_SESSION['Username'] === 'admin' ) )
{
	echo "To access this page you need to login as Admin. Please log in first.";
	die();
}



require_once "../../LocalSettings.php";
require_once "../Globals.php";


$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd  );

if( $sqlConn->connect_errno ) 
{
	echo "Error connecting database. Please check your database credentials and update.";
	die();
}

$stmt = $sqlConn->prepare( "create database if not exists $applnDB" );

if( ! $stmt->execute() )
{
	echo "Error creating database.";
	die();
}

$stmt->close();
$sqlConn->close();


$html = <<<HTML
<html>
<head>
<title>Create Application Type</title>
</head>
<body>
<p>Please enter the details to create a new application type :</p><br><br>
<form action="initApplnDB.php" method="post">
Name of the Application type (eg. duty leave, etc.) : <input type="text" name="applnTypeName" required><br><br>
Now enter/check the input fields to be required for this type of application (eg., reason, your hometown, etc.) :<br><br> 
<input type="checkbox" name="isStartDate" value="startIncluded">Includes Stard date.<br>
<input type="checkbox" name="isEndDate" value="endIncluded">Includes End date.<br>
Now click 'Add a field' again and again to start naming the input field(s) or 'Done' to complete the procedure :<br>
<div id="inputFields">
</div>
<br><button onclick="askInputField()">Add a field</button><br>
<button type="submit" name="submit">Done</button>
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
function askInputField ()
{
$("#inputFields").append("The name of this input field : <input type='text' name='inputFields[]' required><br>");
}
</script>
</body>
</html>
HTML;

echo $html;



?>
