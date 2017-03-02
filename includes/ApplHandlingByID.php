<?php

/*
 *
 * to handle different tasks on an application such as approving , checking , accepting etc., via ID of the applications store in the database.
 *
 */



require_once "../../LocalSettings.php";
require_once "../Globals.php";



$sqlconn = new mysqli ( $eorgDBserver, $eorgDBuser, $eorgDBpasswd, $eorgDBname );

if ( $sqlconn->connect_errno )
{
	echo "Internal Server Error, Sorry for inconvenience.";
	die();
}

$qry = "SELECT * FROM $AppDB WHERE $AppId = ?";
$stmt = $sqlconn->prepare ( $qry );


function isApproved ( $id, $user )  // checking wether application is approved or not
{
	global $stmt;
	$stmt = $stmt;
	$stmt->bind_param ( 's', $id );
	if ( ! $stmt->execute() )
	{
		echo "there is a problem in the database , inconvinence caused is deeply regreted.";
		die();
	}
	else
	{
		$result = $stmt->get_result();
		$row = mysqli_fetch_row ( $result );
		$status = explode ( ';', $row[2] );
		for ( $i = 1 ; $i < count ( $status ) ; $i++ )
		{
			$Stat = explode ( ',', $status[$i] );
			if ( strcmp ( $user, $Stat[0] ) == 0 )
			{
				if ( $Stat[1] == 'A' )
					return true;
				else
					return false;
			}
		}
		return false;
		$stmt->close();
	}
}


function isAccepted ( $id, $user )
{
	global $stmt;
	$stmt = $stmt;
	$stmt->bind_param ( 's', $id );
	if ( ! $stmt->execute() )
	{
		echo "Sorry, there is a problem with database.";
		die();
	}
	else
	{
		$result = $stmt->get_result();
		$row = mysqli_fetch_row ( $result );
		$status = explode ( ';', $row[2] );
		for ( $i = 1 ; $i < count ( $status ) ; $i++ )
		{
			$Stat = explode ( ',', $status[$i] );
			if ( strcmp ( $user, $Stat[0] ) == 0 )
			{
				if ( $Stat[1] == 'Y' )
					return true;
				else
					return false;
			}
		}
		return false;
		$stmt->close();
	}
}


function approve ( $id, $user )
{
	global $stmt;
	$stmt = $stmt;
	$stmt->bind_param ( 's', $id );
	if ( ! $stmt->execute() )
	{
		echo "Sorry, there is a problem with database.";
		die();
	}
	else
	{
		$result = $stmt->get_result();
		$row = mysqli_fetch_row ( $result );
		$status = explode ( ';', $row[2] );
		$newStatus = $status[0]; // to create the new status.
		$flag = 0;       // a flag to check wether the status has been updated or not.
		for ( $i = 1 ; $i < count ( $status ) ; $i++ )
		{
			$Stat = explode ( ',', $status[$i] );
			if ( strcmp ( $user, $Stat[0] ) == 0 )
			{
				$flag = $i;
				if ( $Stat[1] == 'P' )
				{
					$Stat[1] = 'A';
					$status[$i] = $Stat[0].",".$Stat[1];
				}
			}
			$newStatus = $newStatus.";".$status[$i];
		}
		if ( $flag != 0 )
		{
			global $sqlconn; $sqlconn = $sqlconn;
			global $AppDB; $AppDB = $AppDB;
			global $AppId; $AppId = $AppId;
			global $stat; $stat = $stat;
			$QRY = "UPDATE $AppDB SET $stat = ? WHERE $AppId = ?";
			$STMT = $sqlconn->prepare ( $QRY );
			$STMT->bind_param ( 'ss', $newStatus, $id );
			if ( ! $STMT->execute() )
			{
				echo " Unable to perform the task, internal server error.<br>";
				die();
			}
			$next = explode ( ',', $status[ $flag + 1 ] );
			$NEXT = str_replace('.','$', $next[0] );
			$STMT  = $sqlconn->prepare ( "INSERT INTO $NEXT VALUES ( ?, ? )" );
			$STMT->bind_param ( 'ss', $id, $row[1] );
			if ( ! $STMT->execute() )
			{
				echo " Unable to perform the task, internal server error.<br>";
				die();
			}
			$STMT->close();
			
		}
		else
			return false;
	}
	$stmt->close();
}




function accept ( $id, $user )
{
	global $stmt;
	$stmt = $stmt;
	$stmt->bind_param ( 's', $id );
	if ( ! $stmt->execute() )
	{
		echo "Sorry, there is a problem with database.";
		die();
	}
	else
	{
		$result = $stmt->get_result();
		$row = mysqli_fetch_row ( $result );
		$status = explode ( ';', $row[2] );
		$newStatus = $status[0]; // to create the new status.
		$flag = 0;       // a flag to check wether the status has been updated or not.
		for ( $i = 1 ; $i < count ( $status ) ; $i++ )
		{
			$Stat = explode ( ',', $status[$i] );
			if ( strcmp ( $user, $Stat[0] ) == 0 )
			{
				$flag = 1;
				if ( $Stat[1] == 'P' )
				{
					$Stat[1] = 'Y';
					$status[$i] = $Stat[0].",".$Stat[1];
				}
			}
			$newStatus = $newStatus.";".$status[$i];
		}

		if ( $flag != 0 )
		{
			global $sqlconn; $sqlconn = $sqlconn;
			global $AppDB; $AppDB = $AppDB;
			global $AppId; $AppId = $AppId;
			global $stat; $stat = $stat;
			$QRY = "UPDATE $AppDB SET $stat = ? WHERE $AppId = ?";

			$STMT = $sqlconn->prepare ( $QRY );
			$STMT->bind_param ( 'ss', $newStatus, $id );
			if ( ! $STMT->execute() )
			{
				echo " Unable to perform the task, internal server error.<br>";
				die();
			}
			$STMT->close();
		}
		else
			return false;
	}
	$stmt->close();
}



function isGenerator ( $id, $user )
{
	global $stmt;
	$stmt = $stmt;
	$stmt->bind_param ( 's', $id );

	if ( ! $stmt->execute() )
	{
		echo " there is a problem with the server<br>";
		die();
	}
	else
	{
		$result = $stmt->get_result();
		$row = mysqli_fetch_row ( $result );
		$status = explode ( ';', $row[2] );
		$Stat = explode ( ',', $status[0] );
		if ( strcmp ( $Stat[0], $user ) == 0 )
		{
			return $row[2];
		}
		else
		{
			return false;
		}
	}
}




function isAccepter ( $id, $user )
{
	global $stmt;
	$stmt = $stmt;
	$stmt->bind_param ( 's', $id );
	if ( ! $stmt->execute() )
	{
		echo " there is a problem with the server<br>";
		die();
	}
	else
	{
		$result = $stmt->get_result();
		$row = mysqli_fetch_row ( $result );
		$status = explode ( ';', $row[2] );
		$Stat = explode ( ',', $status[ count ( $status ) - 1] );
		if ( strcmp ( $Stat[0], $user ) == 0 )
		{
			return $row[2];
		}
		else
		{
			return false;
		}
	}
}


function isApprover ( $id, $user )
{
	global $stmt;
	$stmt = $stmt;
	$stmt->bind_param ( 's', $id );
	if ( ! $stmt->execute() )
	{
		echo "there is a problem with the database<br>";
		die();
	}
	else
	{
		$result = $stmt->get_result();
		$row = mysqli_fetch_row ( $result );
		$status = explode ( ';', $row[2] );
		for ( $i = 1 ; $i < count ( $status ) - 1 ; $i++ )
		{
			$Stat = explode ( ',', $status[$i] );
			if ( strcmp ( $user, $Stat[0] ) == 0 )
			{
				return $row[2];
			}
		}
		return false;
	}
}

function whoIsApprover ( $id )
{
	global $stmt;
	$stmt = $stmt;

	$stmt->bind_param ( 's', $id );

	if ( ! $stmt->execute() )
	{
		echo "there is a problem with the database<br>";
		die();
	}
	else
	{
		$result = $stmt->get_result();
		$row = mysqli_fetch_row ( $result );
		$status = explode ( ';', $row[2] );
		$Stat = explode ( ',', $status[1] );

		return $Stat[0];
	}
}



function whoIsAccepter ( $id )
{
	global $stmt;
	$stmt = $stmt;
	$stmt->bind_param ( 's', $id );
	if ( ! $stmt->execute() )
	{
		echo "there is a problem with the database<br>";
		die();
	}
	else
	{
		$result = $stmt->get_result();
		$row = mysqli_fetch_row ( $result );
		$status = explode ( ';', $row[2] );
		$Stat = explode ( ',', $status[count ( $status ) -1] );
		return $Stat[0];
	}
}









?>
