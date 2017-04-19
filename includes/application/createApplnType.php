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
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="shortcut icon" href="/favicon.png" type="image/png">
<link rel="shortcut icon" type="image/png" href="../../image/gogreen.jpg" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>

input[type=text] {
    
    width: 400px;
   height:35px;
  font-size:25px;
}

button,select
{
	cursor: pointer; font-size : 25px; height:auto; width:auto ;background-color:#000000;color:white ;
	border: 0.25px solid white;
}

body {
	
    font-size:30px;
    color:white;
    background-image: url("../../image/image4.jpg");
     min-height: 500px;
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}
</style>
</head>
<body>

<br>
<center><i><br><br><br>

<button onclick="document.location.href='../../'" > HOME</button><br><br>
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
$("#inputFields").append("The name of this input field : <input type='text' name='inputFields[]' pattern='[A-Za-z0-9 _]{1,}' title='only alphabets, numbers and under_score are allowed' required><br>");
}
</script>
<br><br><br><br><br><br></body>
</html>
HTML;

echo $html;



?>
