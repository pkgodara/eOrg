<?php
/*
 * setup MySql database.
 */

$DBtype = $_POST['dbclient'];
$DBserver = $_POST['dbserver'];
$DBname = $_POST['dbname'];
$Uname = $_POST['mysqlUname'];
$passwd = $_POST['mysqlPasswd'];


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

\$eorgDBtype = "$DBtype";
\$eorgDBserver = "$DBserver";
\$eorgDBname = "$DBname";
\$eorgDBuser = "$Uname";
\$eorgDBpasswd = "$passwd";

?>
EOT;


$fs = fopen( $file , "x+" ) or die(page("Unable to create/open LocalSettings.php in installation Folder.","Complete Error details : ",error_get_last(), $output ));


	fwrite(  $fs , $output );
	fclose($fs);

page("Bravo! Successfully created LocalSettings.php in installation Folder.","",$output);


function page($title,$info,$details,$out) {

$output = <<<HTML
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

</body>
<html>

HTML;

echo $output;

}


?>
