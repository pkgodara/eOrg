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
$query = "CREATE TABLE IF NOT EXISTS $loginDB ( $UName VARCHAR(50) NOT NULL, $UPasswd VARCHAR(60) NOT NULL, $FName VARCHAR(60) NOT NULL, $Desig VARCHAR(255) NOT NULL, PRIMARY KEY($UName) )" ;

$stmt = $sqlConn->prepare( $query );


if ( ! $stmt->execute() ) // if unsuccessful
{
	echo "Error creating user database.";
	die();
}
$stmt->close();


// Create [ Database => username ] storing tables in Database
//
$query = "CREATE TABLE IF NOT EXISTS $DesigDB ( $Desig VARCHAR(20) NOT NULL, $UName VARCHAR(50) NOT NULL, INDEX idx USING BTREE ($Desig) )";

$stmt = $sqlConn->prepare( $query );


if ( ! $stmt->execute() ) // if unsuccessful
{
	echo "Error creating design database.";
	die();
}
$stmt->close();


// create application tables to store application data
//
$query = "CREATE TABLE IF NOT EXISTS $AppDB ( $AppId BIGINT UNSIGNED AUTO_INCREMENT NOT NULL , $AppTy VARCHAR(5) , $stat VARCHAR(255) NOT NULL, $AFrom VARCHAR(10) NOT NULL , $AUpto VARCHAR(10) NOT NULL , $AReason VARCHAR(255) NOT NULL , PRIMARY KEY($AppId) )" ;

$stmt = $sqlConn->prepare( $query );


if( ! $stmt->execute() )
{
	echo "Error creating application database";
	die();
}
$stmt->close();

// Store credentials in DB
//
$query = "Insert INTO $loginDB VALUES ( ? , ? , ? , ? )" ;
$stmt = $sqlConn->prepare( $query );
$stmt->bind_param( 'ssss', $user , $hash , $user , $user );


if( ! $stmt->execute() )
{
	echo "Error updating database information";
}

$stmt->close();
$sqlConn->close();



// Everything alright...............


echo "All Setup , Now you can use admin credentials to login and add users." ;

?>
