<?php

/*
 *
 * to handle different tasks on an application such as approving , checking , accepting etc., via ID of the applications store in the database.
 *
 */



function isApproved ( $id, $type , $user )  // checking wether application is approved or not
{
	require "../../LocalSettings.php";
	require "../Globals.php";

	$sqlconn = new mysqli ( $eorgDBserver, $eorgDBuser, $eorgDBpasswd, $eorgDBname );

	if ( $sqlconn->connect_errno )
	{
		echo "Internal Server Error 1, Sorry for inconvenience.";
		die();
	}

	$qry = "SELECT $stat FROM $type WHERE $AppId = ?";
	$stmt = $sqlconn->prepare ( $qry );

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
		$status = explode ( ';', $row[0] );
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


function isAccepted ( $id, $type, $user )
{
	require "../../LocalSettings.php";
	require "../Globals.php";

	$sqlconn = new mysqli ( $eorgDBserver, $eorgDBuser, $eorgDBpasswd, $eorgDBname );

	if ( $sqlconn->connect_errno )
	{
		echo "Internal Server Error 2, Sorry for inconvenience.";
		die();
	}

	$qry = "SELECT $stat FROM $type WHERE $AppId = ?";
	$stmt = $sqlconn->prepare ( $qry );

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
		$status = explode ( ';', $row[0] );
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


function approve ( $id, $type, $user )
{
	require "../../LocalSettings.php";
	require "../Globals.php";

	$sqlconn = new mysqli ( $eorgDBserver, $eorgDBuser, $eorgDBpasswd, $eorgDBname );

	if ( $sqlconn->connect_errno )
	{
		echo "Internal Server Error 3, Sorry for inconvenience.";
		die();
	}

	$qry = "SELECT $stat, $AppDate FROM $type WHERE $AppId = ?";
	$stmt = $sqlconn->prepare ( $qry );

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
		$status = explode ( ';', $row[0] );
		$newStatus = $status[0]; // to create the new status.
		$flag = 0;       // a flag to check wether the status has been updated or not.
		for ( $i = 1 ; $i < count ( $status ) ; $i++ )
		{
			$Stat = explode ( ',', $status[$i] );
			if ( strcmp ( $user, $Stat[0] ) == 0 )
			{
				$flag = $i;
				if ( $Stat[1] == 'P' | $Stat[1] == 'F' )
				{
					$Stat[1] = 'A';
					$status[$i] = $Stat[0].",".$Stat[1];
				}
			}
			$newStatus = $newStatus.";".$status[$i];
		}
		if ( $flag != 0 )
		{
			$QRY = "UPDATE $type SET $stat = ? WHERE $AppId = ?";
			$STMT = $sqlconn->prepare ( $QRY );
			$STMT->bind_param ( 'ss', $newStatus, $id );
			if ( ! $STMT->execute() )
			{
				echo " Unable to perform the task, internal server error.<br>";
				die();
			}
			$next = explode ( ',', $status[ $flag + 1 ] );
			$NEXT = str_replace('.','$', $next[0] );
			$NEXT = str_replace(' ','_', $NEXT );
			$STMT  = $sqlconn->prepare ( "INSERT INTO $NEXT VALUES ( ?,?,? )" );
			$STMT->bind_param ( 'sss', $id, $type, $row[1] );
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



function reject( $id, $type, $user )
{
	require "../../LocalSettings.php";
	require "../Globals.php";

	$sqlconn = new mysqli ( $eorgDBserver, $eorgDBuser, $eorgDBpasswd, $eorgDBname );

	if ( $sqlconn->connect_errno )
	{
		echo "Internal Server Error 3, Sorry for inconvenience.";
		die();
	}

	$qry = "SELECT $stat FROM $type WHERE $AppId = ?";
	$stmt = $sqlconn->prepare ( $qry );

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
		$status = explode ( ';', $row[0] );
		$newStatus = $status[0]; // to create the new status.
		$flag = 0;       // a flag to check wether the status has been updated or not.
		for ( $i = 1 ; $i < count ( $status ) ; $i++ )
		{
			$Stat = explode ( ',', $status[$i] );
			if ( strcmp ( $user, $Stat[0] ) == 0 )
			{
				$flag = $i;
				if ( $Stat[1] == 'P' | $Stat[1] == 'F' )
				{
					$Stat[1] = 'R';
					$status[$i] = $Stat[0].",".$Stat[1];
				}
			}
			$newStatus = $newStatus.";".$status[$i];
		}
		if ( $flag != 0 )
		{
			$QRY = "UPDATE $type SET $stat = ? WHERE $AppId = ?";
			$STMT = $sqlconn->prepare ( $QRY );
			$STMT->bind_param ( 'ss', $newStatus, $id );
			if ( ! $STMT->execute() )
			{
				echo " Unable to perform the task, internal server error.<br>";
				die();
			}
			
			$STMT->close();
			return true;
		}
		else
			return false;
	}
	$stmt->close();
	return true;
}



function accept ( $id, $type, $user )
{
	require "../../LocalSettings.php";
	require "../Globals.php";

	$sqlconn = new mysqli ( $eorgDBserver, $eorgDBuser, $eorgDBpasswd, $eorgDBname );

	if ( $sqlconn->connect_errno )
	{
		echo "Internal Server Error 4, Sorry for inconvenience.";
		die();
	}

	$qry = "SELECT $stat FROM $type WHERE $AppId = ?";
	$stmt = $sqlconn->prepare ( $qry );

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
		$status = explode ( ';', $row[0] );
		$newStatus = $status[0]; // to create the new status.
		$flag = 0;       // a flag to check wether the status has been updated or not.
		for ( $i = 1 ; $i < count ( $status ) ; $i++ )
		{
			$Stat = explode ( ',', $status[$i] );
			if ( strcmp ( $user, $Stat[0] ) == 0 )
			{
				$flag = 1;
				if ( $Stat[1] == 'P' | $Stat[1] == 'F' )
				{
					$Stat[1] = 'Y';
					$status[$i] = $Stat[0].",".$Stat[1];
				}
			}
			$newStatus = $newStatus.";".$status[$i];
		}

		if ( $flag != 0 )
		{
			$QRY = "UPDATE $type SET $stat = ? WHERE $AppId = ?";

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


function forwardApprover ( $id, $type, $user )
{
	require "../../LocalSettings.php";
	require "../Globals.php";

	$sqlconn = new mysqli ( $eorgDBserver, $eorgDBuser, $eorgDBpasswd, $eorgDBname );

	if ( $sqlconn->connect_errno )
	{
		echo "Internal Server Error, Sorry for inconvenience.";
		die();
	}

	$qry = "SELECT $stat, $AppDate FROM $type WHERE $AppId = ?";
	$stmt = $sqlconn->prepare ( $qry );

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
		$status = explode ( ';', $row[0] );
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
					$Stat[1] = 'F';
					$status[$i] = $Stat[0].",".$Stat[1];
				}
			}
			$newStatus = $newStatus.";".$status[$i];
		}
		if ( $flag != 0 )
		{
			$QRY = "UPDATE $type SET $stat = ? WHERE $AppId = ?";
			$STMT = $sqlconn->prepare ( $QRY );
			$STMT->bind_param ( 'ss', $newStatus, $id );
			if ( ! $STMT->execute() )
			{
				echo " Unable to perform the task, internal server error.<br>";
				die();
			}
			$next = explode ( ',', $status[ $flag + 1 ] );
			$NEXT = str_replace('.','$', $next[0] );
			$NEXT = str_replace(' ','_', $NEXT );
			$STMT  = $sqlconn->prepare ( "INSERT INTO $NEXT VALUES ( ?,?,? )" );
			$STMT->bind_param ( 'sss', $id, $type, $row[1] );
			if ( ! $STMT->execute() )
			{
				echo " Unable to perform the task, internal server error.<br>";
				die();
			}
			$STMT->close();

		}
		else
		{
			return false;
		}
	}
	$stmt->close();
	
	return true;
}



function forwardAcceptor ( $id, $type, $user, $next )
{
	require "../../LocalSettings.php";
	require "../Globals.php";

	$sqlconn = new mysqli ( $eorgDBserver, $eorgDBuser, $eorgDBpasswd, $eorgDBname );

	if ( $sqlconn->connect_errno )
	{
		echo "Internal Server Error 3, Sorry for inconvenience.";
		die();
	}

	$qry = "SELECT $stat, $AppDate FROM $type WHERE $AppId = ?";
	$stmt = $sqlconn->prepare ( $qry );

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
		$status = explode ( ';', $row[0] );
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
					$Stat[1] = 'F';
					$status[$i] = $Stat[0].",".$Stat[1];
				}
			}
			$newStatus = $newStatus.";".$status[$i];
		}
		
		// set next user and status
		$newStatus = $newStatus.";".$next.",P";
		
		if ( $flag != 0 )
		{
			$QRY = "UPDATE $type SET $stat = ? WHERE $AppId = ?";
			$STMT = $sqlconn->prepare ( $QRY );
			$STMT->bind_param ( 'ss', $newStatus, $id );
			if ( ! $STMT->execute() )
			{
				echo " Unable to perform the task, internal server error.<br>";
				die();
			}
			
			$next = str_replace('.','$',$next);
			$next = str_replace(' ','_',$next);
			$STMT  = $sqlconn->prepare ( "INSERT INTO $next VALUES ( ?,?,? )" );
			$STMT->bind_param ( 'sss', $id, $type, $row[1] );
			if ( ! $STMT->execute() )
			{
				echo " Unable to forward. Please confirm POST name.<br>";
				die();
			}
			$STMT->close();

		}
		else
		{
			return false;
		}
	}
	$stmt->close();
	
	return true;
}




function isGenerator ( $id, $type , $user )
{
	require "../../LocalSettings.php";
	require "../Globals.php";

	$sqlconn = new mysqli ( $eorgDBserver, $eorgDBuser, $eorgDBpasswd, $eorgDBname );

	if ( $sqlconn->connect_errno )
	{
		echo "Internal Server Error 5, Sorry for inconvenience.";
		die();
	}

	$qry = "SELECT $stat FROM $type WHERE $AppId = \"$id\"";
	$stmt = $sqlconn->prepare ( $qry );

	//$stmt->bind_param( 's', $id );
	
	if ( ! $stmt->execute() )
	{
		echo " there is a problem with the server<br>";
		die();
	}
	else
	{
		$result = $stmt->get_result();
		$row = mysqli_fetch_row ( $result );
		$status = explode ( ';', $row[0] );
		$Stat = explode ( ',', $status[0] );
		if ( strcmp ( $Stat[0], $user ) == 0 )
		{
			return $row[0];
		}
		else
		{
			return false;
		}
	}
}


function isAccepter ( $id, $type , $user )
{
	require "../../LocalSettings.php";
	require "../Globals.php";

	$sqlconn = new mysqli ( $eorgDBserver, $eorgDBuser, $eorgDBpasswd, $eorgDBname );

	if ( $sqlconn->connect_errno )
	{
		echo "Internal Server Error 6, Sorry for inconvenience.";
		die();
	}

	$qry = "SELECT $stat FROM $type WHERE $AppId = ?";
	$stmt = $sqlconn->prepare ( $qry );

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
		$status = explode ( ';', $row[0] );
		$Stat = explode ( ',', $status[ count ( $status ) - 1] );
		if ( strcmp ( $Stat[0], $user ) == 0 )
		{
			return $row[0];
		}
		else
		{
			return false;
		}
	}
}


function isApprover ( $id, $type , $user )
{
	require "../../LocalSettings.php";
	require "../Globals.php";

	$sqlconn = new mysqli ( $eorgDBserver, $eorgDBuser, $eorgDBpasswd, $eorgDBname );

	if ( $sqlconn->connect_errno )
	{
		echo "Internal Server Error 7, Sorry for inconvenience.";
		die();
	}

	$qry = "SELECT $stat FROM $type WHERE $AppId = ?";
	$stmt = $sqlconn->prepare ( $qry );

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
		$status = explode ( ';', $row[0] );
		for ( $i = 1 ; $i < count ( $status ) - 1 ; $i++ )
		{
			$Stat = explode ( ',', $status[$i] );
			if ( strcmp ( $user, $Stat[0] ) == 0 )
			{
				return $row[0];
			}
		}
		return false;
	}
}

function whoIsGenerator( $id , $type )
{
	require "../../LocalSettings.php";
	require "../Globals.php";

	$sqlconn = new mysqli ( $eorgDBserver, $eorgDBuser, $eorgDBpasswd, $eorgDBname );

	if ( $sqlconn->connect_errno )
	{
		echo "Internal Server Error 8, Sorry for inconvenience.";
		die();
	}

	$qry = "SELECT $stat FROM $type WHERE $AppId = ?";
	$stmt = $sqlconn->prepare ( $qry );

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
		$status = explode ( ';', $row[0] )[0];
		$Stat = explode ( ',', $status )[0];

		return $Stat;
	}
}

function whoIsApprover ( $id , $type )
{
	require "../../LocalSettings.php";
	require "../Globals.php";

	$sqlconn = new mysqli ( $eorgDBserver, $eorgDBuser, $eorgDBpasswd, $eorgDBname );

	if ( $sqlconn->connect_errno )
	{
		echo "Internal Server Error 8, Sorry for inconvenience.";
		die();
	}

	$qry = "SELECT $stat FROM $type WHERE $AppId = ?";
	$stmt = $sqlconn->prepare ( $qry );

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
		$status = explode ( ';', $row[0] );
		$Stat = explode ( ',', $status[1] );

		return $Stat[0];
	}
}



function whoIsAccepter ( $id , $type )
{
	require "../../LocalSettings.php";
	require "../Globals.php";

	$sqlconn = new mysqli ( $eorgDBserver, $eorgDBuser, $eorgDBpasswd, $eorgDBname );

	if ( $sqlconn->connect_errno )
	{
		echo "Internal Server Error 9, Sorry for inconvenience.";
		die();
	}

	$qry = "SELECT $stat FROM $type WHERE $AppId = ?";
	$stmt = $sqlconn->prepare ( $qry );

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
		$status = explode ( ';', $row[0] );
		$Stat = explode ( ',', $status[count ( $status ) -1] );
		return $Stat[0];
	}
}


?>
