<?php
/*
 * setup MySql database.
 */

$DBtype = $_POST['dbclient'];
$DBserver = $_POST['dbserver'];
$DBname = $_POST['dbname'];
$Uname = $_POST['mysqlUname'];
$passwd = $_POST['mysqlPasswd'];


#function generateLocalSettings($DBtype,$DBserver,$DBname,$Uname,$passwd) {

$file = '../../LocalSettings.php';

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

\$eorgDBtype = "\$DBtype";
\$eorgDBserver = "\$DBserver";
\$eorgDBname = "\$DBname";
\$eorgDBuser = "\$Uname";
\$eorgDBpasswd = "\$passwd";

?>
EOT;

$page = <<<HTML
<!DOCTYPE html>
<html>
<head>
<title>Local Settings</title>
</head>

<body>
<h2>Error creating LocalSettings.php file.</h2>
</body>

</html>

$fs = fopen( $file , "x+" ) or die(print_r(error_get_last())."\nUnable to create/open LocalSettings.php , Please make sure you have write permissions in your installation folder");


	fwrite(  $fs , $output );
	fclose($fs);
	echo "LocalSettings.php created.";

?>
