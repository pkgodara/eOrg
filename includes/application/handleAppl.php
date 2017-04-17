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
$UID;

if( isset( $_SESSION['PostName']) )
{
	$UID = $_SESSION['PostName'] ;
}
else
{
	$UID = $_SESSION['Username'];
}
$USER= str_replace('.','$',$UID );



$html = <<<HTML
<!DOCTYPE html>
<html>
<head>
	<title>Handling Applications</title>
<link rel="shortcut icon" href="/favicon.png" type="image/png">
<link rel="shortcut icon" type="image/png" href="../../image/gogreen.jpg" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>


body {
    color:white;
    background-image: url("../../image/image4.jpg");
     min-height: 500px;
    background-attachment: fixed;
    background-position: center;
   
    background-size: cover;
    background-repeat: no-repeat;
}
table, td, th {
    text-align:center;
    border: 1px solid black;
}

table {
    width: 100%;
    border-color: white;
}

th {
    height: 50px;
}

input[type=submit],button
{
	cursor: pointer; font-size : 25px; height:auto; width:auto ;background-color:transparent;color:white ;
	border: 0.25px solid white;
}
</style>
</head>
<body><br><br>
HTML;

echo "$html";

if ($_SESSION['PostName'])
{
echo "<button onclick=\"document.location.href='../dashboard/PostDashBoard.php'\" > HOME </button>";
}
else
echo "<button onclick=\"document.location.href='../../'\" > HOME </button>";


$html = <<<HTML
<center><b><i><br><br>
Hello $UID <br><br>

<table>
<caption style="font-size:200%;align-text:center"> Your Applications</caption>
<tr>
<td>Sr. no</td>
<td>Application ID</td>
<td>Application type</td>
<td>Generation Date</td>
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
$stm = $sqlConn->prepare("SELECT * FROM $USER ORDER BY $AppDate DESC, $AppId DESC");

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
	$genDate = $ROW[2];
	$html = <<<HTML
<tr> <td>$i</td>
<td>$app_id</td>
<td>$app_type</td>
<td>$genDate</td>
	
<td>
<form action="viewApplication.php" method="post">
<input type="text" name="app_id" value=$app_id style="visibility: hidden; display: none;" readonly>
<input type="text" name="app_type" value=$app_type style="visibility: hidden; display: none;" readonly>
<input type="submit" value="View">
</form>
</td>
HTML;
	
	echo $html;
	
	
	if ( ($Status = isGenerator ( $ROW[0], $ROW[1], $UID )) != false )
	{
		
		showStatus( $Status ); // print complete status
		
		$curDate = date('Y-m-d'); 
		
		if( ( strtotime($curDate) - strtotime($genDate) ) > 10*24*60*60 )
		{
			$pending = false;
			
			$st = explode(';',$Status);
			
			for( $i = 1 ; $i < count($st) ; $i++ )
			{
				$val = explode(',',$st[$i])[1];
				if( $val == 'P' )
				{
					$pending = true;
					break;
				}
			}
			
			if( $pending == true )
			{
				echo <<<HTML
<td>
<form action="forwardApplication.php" method="post">
<input type="text" name="app_id" value=$app_id style="visibility: hidden; display: none;" readonly>
<input type="text" name="app_type" value=$app_type style="visibility: hidden; display: none;" readonly>
<input type="text" name="status" value=$Status style="visibility: hidden; display: none;" readonly>
<input type="submit" value="Forward">
</form>
</td>
HTML;
			}
		}
		
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
		else if( str_isForwarded( $Status, $UID ) )
		{
			echo "<td>You have <b>FORWARDED</b> it</td>";
		}
		else 
		{
			echo <<<HTML
<td>
<form action="ApproveAppl.php" method="post">
<input type="text" name="app_id" value=$app_id style="visibility: hidden; display: none;" readonly>
<input type="text" name="app_type" value=$app_type style="visibility: hidden; display: none;" readonly>
<input type="submit" value="approve now">
</form>
</td>

<td>
<form action="RejectAppl.php" method="post">
<input type="text" name="app_id" value=$app_id style="visibility: hidden; display: none;" readonly>
<input type="text" name="app_type" value=$app_type style="visibility: hidden; display: none;" readonly>
<input type="submit" value="reject it">
</form>
</td>

<td>
<form action="forwardApplication.php" method="post">
<input type="text" name="app_id" value=$app_id style="visibility: hidden; display: none;" readonly>
<input type="text" name="app_type" value=$app_type style="visibility: hidden; display: none;" readonly>
<input type="text" name="status" value=$Status style="visibility: hidden; display: none;" readonly>
<input type="submit" value="Forward">
</form>
</td>

<td>
<form action="getApplnCount.php" method="post">
<input type="text" name="app_id" value=$app_id style="visibility: hidden; display: none;" readonly>
<input type="text" name="app_type" value=$app_type style="visibility: hidden; display: none;" readonly>
<input type="submit" value="see user history">
</form>
</td>
HTML;
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
		else if( str_isForwarded( $Status, $UID ) )
		{
			echo "<td>You have <b>FORWARDED</b> it</td>";
		}
		else
		{
			echo <<<HTML
<td>
<form action="AcceptAppl.php" method="post">
<input type="text" name="app_id" value=$app_id style="visibility: hidden; display: none;" readonly>
<input type="text" name="app_type" value=$app_type style="visibility: hidden; display: none;" readonly>
<input type="submit" value="accept now">
</form>
</td>

<td>
<form action="RejectAppl.php" method="post">
<input type="text" name="app_id" value=$app_id style="visibility: hidden; display: none;" readonly>
<input type="text" name="app_type" value=$app_type style="visibility: hidden; display: none;" readonly>
<input type="submit" value="reject it">
</form>
</td>

<td>
<form action="forwardApplication.php" method="post">
<input type="text" name="app_id" value=$app_id style="visibility: hidden; display: none;" readonly>
<input type="text" name="app_type" value=$app_type style="visibility: hidden; display: none;" readonly>
<input type="text" name="status" value=$Status style="visibility: hidden; display: none;" readonly>
<input type="submit" value="Forward">
</form>
</td>

<td>
<form action="getApplnCount.php" method="post">
<input type="text" name="app_id" value=$app_id style="visibility: hidden; display: none;" readonly>
<input type="text" name="app_type" value=$app_type style="visibility: hidden; display: none;" readonly>
<input type="submit" value="see user history">
</form>
</td>
HTML;
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
