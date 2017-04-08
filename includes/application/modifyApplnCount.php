<?php 

/*
 * update/delete count of applications for user.
 *
 * date format: yyyy-mm-dd
 *
 */

function decrDay( $date )
{
	$tmp = $DateTime($date);
	$tmp->modify('-1 day');
	return $tmp->format('y-m-d');
}

function incrDay( $date )
{
	$tmp = $DateTime($date);
	$tmp->modify('+1 day');
	return $tmp->format('y-m-d');
}

function updateCount( $user , $type , $date , $cnt )
{
	require_once "../../LocalSettings.php";
	require_once "../Globals.php";

	$sqlconn = new mysqli ( $eorgDBserver, $eorgDBuser, $eorgDBpasswd, $applnCount );

	$result = $sqlconn->query("SELECT * FROM $user WHERE $tillDate = $date AND $applnTy = \"$type\"");

	if( mysqli_num_rows($result) > 0 )
	{
		$prev = mysqli_fetch_array($result)[1];
		$stmt = $sqlconn->prepare("UPDATE $user SET $count = $prev+$cnt WHERE $tillDate = $date AND $applnTy = \"$type\"");
		if( !$stmt->execute() )
		{
			echo "Error updating count" ;
		}
	}
	else
	{
		$prev = 0;
		$res = $sqlconn->query("SELECT $tillDate FROM $user ORDER BY $tillDate limit 1");
		$lim = mysqli_fetch_array($res)[2];
		$lim = explode('-',$lim);
		$flag = false;

		$date = $year.'-'.$month.'-'.$day ;
		$date = decrDay( $date );

		$ar = explode('-',$date);
		$year = $ar[0];
		$month = $ar[1];
		$day = $ar[2];

		while( $year >= $lim[0] && $month >= $lim[1] && $day >= $lim[2] )
		{
			$qry = "SELECT * FROM $user WHERE $tillDate regexp \"$year-$month-$day\" AND $applnTy = \"$type\"";
			$result = $sqlconn->query($qry);
			if( mysqli_num_rows($result) != 0 )
			{
				$row = mysqli_fetch_array($result);
				$prev = $row[1];
				break;
			}

			$date = decrDay( $date );

			$ar = explode('-',$date);
			$year = $ar[0];
			$month = $ar[1];
			$day = $ar[2];
		}

		$stmt = $sqlconn->prepare("INSERT INTO $user VALUES (\"$type\",$prev+$cnt,$date)");
		if( !$stmt->execute() )
		{
			echo "Error updating count" ;
		}
	}

	$sqlconn->close();
}

function deleteCount( $user , $type , $date , $cnt )
{
	require_once "../../LocalSettings.php";
	require_once "../Globals.php";

	$sqlconn = new mysqli ( $eorgDBserver, $eorgDBuser, $eorgDBpasswd, $applnCount );

	$result = $sqlconn->query("SELECT * FROM $user WHERE $tillDate = $date AND $applnTy = \"$type\"");

	if( mysqli_num_rows($result) > 0 )
	{
		$prev = mysqli_fetch_array($result)[1];
		$stmt = $sqlconn->prepare("UPDATE $user SET $count = $prev+$cnt WHERE $tillDate = $date AND $applnTy = \"$type\"");

		$res = $sqlconn->query("SELECT $tillDate FROM $user ORDER BY $tillDate DECR limit 1");
		$lim = mysqli_fetch_array($res)[2];
		$lim = explode('-',$lim);

		$date = $year.'-'.$month.'-'.$day ;

		$ar = explode('-',$date);
		$year = $ar[0];
		$month = $ar[1];
		$day = $ar[2];

		while( $year <= $lim[0] && $month <= $lim[1] && $day <= $lim[2] )
		{
			$qry = "SELECT * FROM $user WHERE $tillDate regexp \"$year-$month-$day\" AND $applnTy = \"$type\"";
			$result = $sqlconn->query($qry);
			if( mysqli_num_rows($result) != 0 )
			{
				$prev = mysqli_fetch_array($result)[1];
				$stmt2 = $sqlconn->prepare("UPDATE $user SET $count = $prev-$cnt WHERE $tillDate = $date AND $applnTy = \"$type\"");
				if( !$stmt2->execute() )
				{
					echo "record not updated $date";
				}
			}

			$date = incrDay( $date );

			$ar = explode('-',$date);
			$year = $ar[0];
			$month = $ar[1];
			$day = $ar[2];
		}

	}
	else
	{
		echo "No application exist on that date";
		die();
	}

	$sqlconn->close();
}

?>
