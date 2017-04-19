<?php

/* 
 * this is to view users category wise
 */
session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && $_SESSION['Username'] === 'admin' ) )
{
	echo "To access this page you need to login as Admin. Please log in first.";
	die();
}


require_once "../../LocalSettings.php";
require_once "../Globals.php";




echo "<p>To view the users groupwise, select the group and click 'view selected group'</p><br><br>";


$sqlConnCat = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $catDB );

if( $sqlConnCat->connect_errno ) 
{
	echo "Internal Server Error, Contact Administrator.";
	die();
}


$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $eorgDBname );

if( $sqlConn->connect_errno ) 
{
	echo "Internal Server Error, Contact Administrator.";
	die();
}


$qryCat = "SELECT TABLE_NAME FROM information_schema.tables WHERE table_schema = ?";
$stmtCat = $sqlConnCat->prepare( $qryCat );
$stmtCat->bind_param ( 's', $catDB );


if ( ! $stmtCat->execute() )
{
	echo"there is a problem with database<br>";
	die ();
}

$resCat = $stmtCat->get_result();

if ( $resCat->num_rows == 0 )
{
	echo "Sorry, first set the broad categories<br>";
	die ();
}

while ($rowCat = mysqli_fetch_row ($resCat))
{
	$newRowCat = str_replace('_', ' ', $rowCat[0]);
	$qry2Cat = "SELECT * FROM $rowCat[0] LIMIT 1"; // to take the level no. of the broad category
	$stmt2Cat = $sqlConnCat->prepare ( $qry2Cat );
	if ( ! $stmt2Cat->execute () )
	{
		echo "Sorry problem with database<br>";
		die ();
	}
	$res2Cat = $stmt2Cat->get_result ();
	$row2Cat = mysqli_fetch_row ( $res2Cat );
	$valueToPass = $rowCat[0].",".$row2Cat[0] ;
	echo "<input type='radio' name='user' value=$valueToPass onclick='startAskingOptions(this.value)'>$newRowCat";
	$stmt2Cat->close();
}

$stmtCat->close();


$html = <<<HTML
<div id='askUserOptions'>
</div><div id='backGround'>
</div>
<button type='button' onclick="showSelectedGroup(document.getElementById('backGround').innerHTML)">View selected group</button>
<div id='users'>
HTML;

echo $html;


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


$qry = "SELECT * FROM $loginDB " ;
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


echo "</table></div>";

$html = <<<HTML
</table>
</div>
HTML;

echo $html;


?>
