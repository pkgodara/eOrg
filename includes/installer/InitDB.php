<?php 

if( !(isset( $_POST['Admin'] ) && isset( $_POST['AdminPasswd'] ) ) )
{
	echo "Credentials not filled.";
	die();
}	

$user = $_POST['Admin'];
$passwd = $_POST['AdminPasswd'];

if( $user != 'admin' || strlen($user) > 50 )
{
	echo "Username Not correct. Max length allowed is 50";
	die();
}


// create Admin and database initialisations.
require_once "../../LocalSettings.php";
require_once "../Globals.php";



// Connect to DB
//
$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $eorgDBname );

if( $sqlConn->connect_errno ) 
{
	echo "Error connecting database. Please check your database credentials and update.";
	die();
}


// create password hash.
$hash = password_hash( $passwd , PASSWORD_BCRYPT );




// Create User-Login Credentials storing tables in Database
//

$query = "CREATE TABLE IF NOT EXISTS $loginDB ( $UName VARCHAR(50) NOT NULL, $UPasswd VARCHAR(60) NOT NULL, $FName VARCHAR(60) NOT NULL, $Sex VARCHAR(15) NOT NULL,$Desig VARCHAR(255) NOT NULL, PRIMARY KEY($UName) )" ;


$stmt = $sqlConn->prepare( $query );



if ( ! $stmt->execute() ) // if unsuccessful
{
	echo "Error creating user database.";
	die();
}
$stmt->close();




// Create [ Database => username ] storing tables in Database
//
$query = "CREATE TABLE IF NOT EXISTS $DesigDB ( $DesigD VARCHAR(20) NOT NULL, $UNameD VARCHAR(50) NOT NULL, INDEX idx USING BTREE ($DesigD) )";

$stmt = $sqlConn->prepare( $query );


if ( ! $stmt->execute() ) // if unsuccessful
{
	echo "Error creating design database.";
	die();
}
$stmt->close();



// Store credentials in DB
//
$query = "Insert INTO $loginDB VALUES ( ? , ? , ? , ? ,?)";
$stmt = $sqlConn->prepare( $query );
$stmt->bind_param( 'sssss', $user , $hash , $user , $user, $user );


if( ! $stmt->execute() )
{
	echo "Error updating database information";
}

$stmt->close();
$sqlConn->close();


// Everything alright...............


echo "All Setup , Now you can use admin credentials to login and add users." ;


// categorising the users............


session_start();
if( !isset( $_SESSION['Username'] ) || !isset($_SESSION['Name']) )
	{
		$_SESSION['Username'] = "admin";
		$_SESSION['Name'] = "admin";
	}
	

// Admin Settings
//
require "initSettings.php";

// categries of users.

require "catUsers.php";
//echo "<a href='catUsers.php'>click here</a><br>";
?>
