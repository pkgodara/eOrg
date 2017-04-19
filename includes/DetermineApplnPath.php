<?php

/* 
 * generate and initiate processing for application.
 *
 */

session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) ) )
{
	echo "You need to login to generate leave applications. Please log in.";
	die();
}



$stmt2 = $sqlConn->prepare("SELECT $Desig FROM $loginDB WHERE $UName = \"$user\"");

if( !$stmt2->execute() )
{
	echo "error creating application database.";
	die();
}

$res2 = $stmt2->get_result();

if ($res2->num_rows == 0)
{
	echo "Sorry, there is some problem<br>";
	die();
}


$row2 = mysqli_fetch_row ($res2);

if (! empty ($row2[0]))
{
	$levelIdArr = explode (';', $row2[0]);
}
else
{
	echo "Sorry there is some problem<br>";
	die();
}

$stmt2->close();

$flag = 0;

for ($i = (count($levelIdArr) - 1) ; $i >= 0 ; $i--)
{
	$stmt2 = $sqlConn->prepare("SELECT $appln FROM $applnPathTable WHERE $groupId = \"$levelIdArr[$i]\"");
	if( !$stmt2->execute() )
	{
		echo "error creating application database.";
		die();
	}

	$res2 = $stmt2->get_result();

	if ( ! $res2->num_rows == 0)
	{
		$row2 = mysqli_fetch_row ($res2);
		if (!empty($row2[0]))
		{
			$flag = 1;
			$postStr = $row2[0];
			break;
		}
	}
	$stmt2->close();
}

if ($flag == 0)
{
	echo "Sorry, ..there is some problem<br>";
	die();
}

$postStrArr = explode (';', $postStr);

$status = $user.",G;";

for ($i = 0 ; $i < (count($postStrArr) - 1) ; $i++)
{
	$status = $status.$postStrArr[$i].",P;";
}

$status = $status.$postStrArr[$i].",P";

?>
