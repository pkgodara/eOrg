<?php

/*
 *
 *  to handle applications in database of a user.
 */

session_start();

if ( !( isset( $_SESSION['Username'] ) && isset( $_SESSION['Name'] ) ) )
{
	echo "session id :".session_id()." ,You must login first to visit this page.";
	die();
}


require "../ApplHandlingByID.php";
require "../ApplHandlingByStr.php";
require_once "../Globals.php";
require_once "../../LocalSettings.php";

$NAME = $_SESSION['Name'];
$UID = $_SESSION['Username'];

$USER= str_replace('.','$',$_SESSION['Username'] );



$html = <<<HTML
<!DOCTYPE html>
<html>
<head>
	<title>Handling Applications</title>
</head>
<body>
Hello $NAME <br><br>

<table>
<caption style="font-size:200%;align-text:center"> Your Applications</caption>
<tr>
<td>Sr. no</td>
<td>Application ID</td>
<td>Application type</td>
</tr>
HTML;

echo "$html";

$sqlConn = new mysqli ( $eorgDBserver, $eorgDBuser, $eorgDBpasswd, $eorgDBname );

if ( $sqlConn->connect_errno )
{
	echo "Internal Server Error, Sorry for inconvenience.";
	die();
}

//$qry = "SELECT * FROM $USER";
$stm = $sqlConn->prepare("SELECT * FROM $USER");

if ( ! $stm->execute() )
{
	echo "there is a problem in the database , inconvinence caused is deeply regreted.";
	die();
}

$res = $stm->get_result();

$i = 1;



while ( $ROW = mysqli_fetch_row ( $res ) )
{
	$app_id = $ROW[0];
	$app_type = $ROW[1];
	$html = <<<HTML
<td>$app_id</td>
<td>$app_type</td>
HTML;
	echo "<tr> <td>$i</td>";

	if ( ($Status = isGenerator ( $ROW[0], $ROW[1], $UID )) != false )
	{
		echo $html;
		showStatus( $Status ); // print complete status
		/*
		if ( str_isApproved ( $Status, $approver = whoIsApprover ( $ROW[0] , $ROW[1] ) ) )
		{
			echo "<td><b>APPROVED</b> by $approver </td>";
		}
		else
		{
			echo "<td><b>PENDING</b> for approval </td>";
		}


		if ( str_isAccepted ( $Status, $accepter = whoIsAccepter ( $ROW[0] , $ROW[1] ) ) )
		{
			echo "<td><b>ACCEPTED</b> by $accepter</td>";
		}
		else
		{
			echo "<td><b>PENDING</b> for acceptence</td>";
		}
		
		if ( str_isRejected ( $Status, $accepter = whoIsAccepter ( $ROW[0] , $ROW[1] ) ) )
		{
			echo "<td><b>REJECTED</b> by $accepter</td>";
		}
		*/
	}
	else if ( ($Status = isApprover ( $ROW[0], $ROW[1] , $UID )) != false )
	{
		if ( str_isApproved ( $Status, $UID ) )
		{
			echo "<td>You have <b>Approved</b> it</td>";
		}
		else if ( str_isRejected ( $Status, $UID) )
		{
			echo "<td>You have <b>Rejected</b> it</td>";
		}
		else 
		{
			$html = <<<HTML
<td>
<form action="ApproveAppl.php" method="post">
<input type="text" name="app_id" value=$app_id readonly>
<input type="text" name="app_type" value=$app_type readonly>
<input type="submit" value="approve now">
</form>
</td>
<td>
<form action="RejectAppl.php" method="post">
<input type="text" name="app_id" value=$app_id readonly>
<input type="text" name="app_type" value=$app_type readonly>
<input type="submit" value="reject it">
</form>
</td>
HTML;
			echo "$html";
		}
	}
	else if ( ($Status =  ( isAccepter ( $ROW[0], $ROW[1], $UID ) )) != false )
	{
		if ( str_isAccepted ( $Status, $UID ) )
		{
			echo "<td>You Have <b>Accepted</b> it.</td>";
		}
		else if ( str_isRejected ( $Status, $UID) )
		{
			echo "<td>You have <b>Rejected</b> it</td>";
		}
		else
		{
			$html = <<<HTML
<td>
<form action="AcceptAppl.php" method="post">
<input type="text" name="app_id" value=$app_id readonly>
<input type="text" name="app_type" value=$app_type readonly>
<input type="submit" value="accept now">
</form>
</td>
<td>
<form action="RejectAppl.php" method="post">
<input type="text" name="app_id" value=$app_id readonly>
<input type="text" name="app_type" value=$app_type readonly>
<input type="submit" value="reject it">
</form>
</td>
HTML;
			echo "$html";
		}
	}


	echo "</tr>";
	$i++;
}

$html = <<<HTML
</table>
</body>
</html>
HTML;

echo "$html";


?>
