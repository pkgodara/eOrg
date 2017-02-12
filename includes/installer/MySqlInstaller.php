<?php
/*
 * setup MySql database.
 */

$DBtype = $_POST['dbclient'];
$DBserver = $_POST['dbserver'];
$DBname = $_POST['dbname'];
$Uname = $_POST['mysqlUser'];
$passwd = $_POST['mysqlPasswd'];

// Database name should only contain alphabets.
if( ! ctype_alpha( $DBname ) )
{
	echo "Database name can contain only alphabets<br>";
	die();
}

if( isset($_POST['dbclient']) && isset($_POST['dbserver']) && isset($_POST['dbname']) && isset($_POST['mysqlUser']) && isset($_POST['mysqlPasswd']) )
{
	//check if provided info is correct
	//
	//using mysqli database driver for executing sql queries
	//
	$mysqlConn = new mysqli( $DBserver , $Uname , $passwd , "" );

	if( $mysqlConn->connect_errno )  //if connection failed
	{
		echo "Sql credentials does not seem correct.<br>" ;
		echo "Errno : ". $mysqlConn->connect_errno ."<br>" ;
		echo "Error : ". $mysqlConn->connect_error ."<br>" ;
		echo "<br><br>Please check you credentials.<br>";

		die();
	}
	//echo "Creating database $DBname";

	//create database if not exists
	//

	$stmt = $mysqlConn->prepare( "create database if not exists $DBname" );

	if( ! $stmt->execute() )
	{
		echo "Error creating database.";
		die();
	}

	$mysqlConn->close();
}
else
{
	echo "You did not fill out the required fields.";
	die();
}


$file = '../../LocalSettings.php';

// content to write in LocalSettings.php
$output = <<<EOT
<?php
/*
 * This file contain Local configuration/Settings for running this software.
 *
 *        DO NOT ALTER THIS INFO
 *        until you know what you are doing.
 *
 */

#Database information

\$eorgDBtype = "$DBtype";
\$eorgDBserver = "$DBserver";
\$eorgDBname = "$DBname";
\$eorgDBuser = "$Uname";
\$eorgDBpasswd = "$passwd";

?>
EOT;


// content to display for manual copying.
$out = <<<EOT
<?php
/*
 * This file contain Local configuration/Settings for running this software.
 *
 *        DO NOT ALTER THIS INFO
 *        until you know what you are doing.
 *
 */ 

#Database information

\$eorgDBtype = "$DBtype";
\$eorgDBserver = "$DBserver";
\$eorgDBname = "$DBname";
\$eorgDBuser = "$Uname";
\$eorgDBpasswd = "$passwd";

?>
EOT;

$code = htmlspecialchars($out,ENT_QUOTES);

// Open/Create LocalSettings.php for read & write
$fs = fopen( $file , "x+" ) or die(page("Unable to create/open LocalSettings.php in installation Folder.","Complete Error details : ",error_get_last() ));

fwrite(  $fs , $output );
fclose( $fs );


page("Bravo! Successfully created LocalSettings.php in installation Folder.","");

// html page generator..
function page($title,$info,$details) {

	global $code;

	$html = <<<HTML
<!DOCTYPE html>
<html>
<head>
<title>Local Settings</title>
</head>

<body>
<h2>$title</h2>
<h4>$info</h4>
<p>$deails</p>
<h3>********      Manual Installation [Only If error in auto-installation]     ******</h3>
<h4>To manually create LocalSettings.php file in the installation folder containing index.php file, Paste the output below :</h4>

$code
<br><br>

<button onclick="document.location.href='/eorg'"> Next </button>

</body>
<html>

HTML;

	echo $html;

}


?>
