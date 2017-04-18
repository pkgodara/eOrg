<?php

/* 
 * this is to show the selected group of the users, selected by the admin
 */
session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && $_SESSION['Username'] === 'admin' ) )
{
	echo "To access this page you need to login as Admin. Please log in first.";
	die();
}



if ( ! isset($_POST['groupId']) )
{
	echo "Sorry, there is some problem";
	die ();
}

$groupID = rtrim($_POST['groupId'], ';');


require_once "../../LocalSettings.php";
require_once "../Globals.php";



$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $eorgDBname );

if( $sqlConn->connect_errno ) 
{
	echo "Internal Server Error, Contact Administrator.";
	die();
}



echo "<h2><br><br><br>The available users are :<br><br></h2>";




$i = 1;

$html = <<<HTML
<table>

<tr>
<th>Sr. No.</th>
<th>User ID</th>
<th>Name</th>
<th>Sex</th>
<th>Designation(s)</th>
</tr>
HTML;

echo $html;


$qry = "SELECT * FROM $loginDB WHERE $Desig REGEXP \"^$groupID\"" ;
$stmt = $sqlConn->prepare ( $qry );
$stmt->execute ( );
$result = $stmt->get_result();
while ( $row = mysqli_fetch_row ( $result ) )
{

$html = <<<HTML
<tr>
<td>$i.</td>
<td>$row[0]</td>
<td>$row[2]</td>
<td>$row[3]</td>
<td><div id="$row[0]"><button type='button' name="$row[0]" value="$row[4]" onclick='viewUserDesign(this.name, this.value)'>View Designation</button></div></td>
</tr>
HTML;

	echo $html;
	$i = $i + 1;
}
$stmt->close();
$sqlConn->close();

echo "</table>";



?>
