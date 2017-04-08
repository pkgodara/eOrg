<?php
/*
 * functions to count applications.
 *
 * date format : yyyy-mm-dd
 */


function countTypeOfAppln()
{
	require_once "../../LocalSettings.php";
	require_once "../Globals.php";

	$sqlconn = new mysqli ( $eorgDBserver, $eorgDBuser, $eorgDBpasswd );
	$count = array();
	$res = $sqlconn->query("SELECT * FROM information_schema.tables WHERE table_schema = $applnDB");

	while( $row = $res->fetch_row() )
	{
		array_push($count,$row[0]);
	}

	$sqlconn->close();
	return $count;
}

function decrYear( $date )
{
	$tmp = $DateTime($date);
	$tmp->modify('-1 year');
	return $tmp->format('y-m-d');
}

function decrMonth( $date )
{
	$tmp = $DateTime($date);
	$tmp->modify('-1 month');
	return $tmp->format('y-m-d');
}

function decrDay( $date )
{
	$tmp = $DateTime($date);
	$tmp->modify('-1 day');
	return $tmp->format('y-m-d');
}

function countApplnInYear( $user , $year )
{
	require_once "../../LocalSettings.php";
	require_once "../Globals.php";

	$sqlconn = new mysqli ( $eorgDBserver, $eorgDBuser, $eorgDBpasswd, $applnCount );

	$count = new stdClass();
	$type = countTypeOfAppln();
	$i = 0;

	while( $i < count($type) )
	{
		$qry1 = "SELECT * FROM $user WHERE $tillDate regexp \"$year-*\" AND $applnTy = $type[$i] ORDER BY $tillDate DESC limit 1";
		$result1 = $sqlconn->query($qry1);

		if( $result1->num_rows() == 0 )
		{
			$count->$type[$i] = 0;
		}
		else
		{
			$row1 = $result1->fetch_array();
			$lim = $sqlconn->query("SELECT $tillDate FROM $user ORDER BY $tillDate limit 1");
			$lim = explode('-',$lim)[0];
			$flag = false;
			$year = $year-1;

			while( $year >= $lim )
			{
				$qry = "SELECT * FROM $user WHERE $tillDate regexp \"$year-*\" AND $applnTy = $type[$i] ORDER BY $tillDate DESC limit 1";
				$result = $sqlconn->query($qry);
				if( $result->num_rows() != 0 )
				{
					$row2 = $result->fetch_array();
					$count->$row1[0] = $row1[1]-$row2[1];
					$flag = true;
					break;
				}
				$year = $year-1;
			}

			if( !flag )
				$count->$row1[0] = $row1[1];
		}

	}
	$sqlconn->close();
	return $count;
}

function countApplnInMonth( $user, $month, $year )
{
	require_once "../../LocalSettings.php";
	require_once "../Globals.php";

	$sqlconn = new mysqli ( $eorgDBserver, $eorgDBuser, $eorgDBpasswd, $applnCount );

	$count = new stdClass();

	$type = countTypeOfAppln();
	$i = 0;

	while( $i < count($type) )
	{
		$qry1 = "SELECT * FROM $user WHERE $tillDate regexp \"$year-$month-*\" AND $applnTy = $type[$i] ORDER BY $tillDate DESC limit 1";
		$result1 = $sqlconn->query($qry1);

		if( $result1->num_rows() == 0 )
		{
			$count->$type[$i] = 0;
		}
		else
		{
			$row1 = $result1->fetch_array();
			$lim = $sqlconn->query("SELECT $tillDate FROM $user ORDER BY $tillDate limit 1");
			$lim = explode('-',$lim);
			$flag = false;

			$date = $year.'-'.$month.'-01';
			$date = decrMonth( $date );

			$ar = explode('-',$date);
			$year = $ar[0];
			$month = $ar[1];

			while( $year >= $lim[0] && $month >= $lim[1] )
			{
				$qry = "SELECT * FROM $user WHERE $tillDate regexp \"$year-$month-*\" AND $applnTy = $type[$i] ORDER BY $tillDate DESC limit 1";
				$result = $sqlconn->query($qry);
				if( $result->num_rows() != 0 )
				{
					$row2 = $result->fetch_array();
					$count->$row1[0] = $row1[1]-$row2[1];
					$flag = true;
					break;
				}

				$date = decrMonth( $date );

				$ar = explode('-',$date);
				$year = $ar[0];
				$month = $ar[1];
			}

			if( !flag )
				$count->$row1[0] = $row1[1];
		}

	}

	$sqlconn->close();
	return $count;
}

function countApplnOnDay( $user, $day, $month, $year )
{
	require_once "../../LocalSettings.php";
	require_once "../Globals.php";

	$sqlconn = new mysqli ( $eorgDBserver, $eorgDBuser, $eorgDBpasswd, $applnCount );

	$count = new stdClass();

	$type = countTypeOfAppln();
	$i = 0;

	while( $i < count($type) )
	{
		$qry1 = "SELECT * FROM $user WHERE $tillDate regexp \"$year-$month-$day\" AND $applnTy = $type[$i] ORDER BY $tillDate DESC limit 1";
		$result1 = $sqlconn->query($qry1);

		if( $result1->num_rows() == 0 )
		{
			$count->$type[$i] = 0;
		}
		else
		{
			$row1 = $result1->fetch_array();
			$lim = $sqlconn->query("SELECT $tillDate FROM $user ORDER BY $tillDate limit 1");
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
				$qry = "SELECT * FROM $user WHERE $tillDate regexp \"$year-$month-$day\" AND $applnTy = $type[$i] ORDER BY $tillDate DESC limit 1";
				$result = $sqlconn->query($qry);
				if( $result->num_rows() != 0 )
				{
					$row2 = $result->fetch_array();
					$count->$row1[0] = $row1[1]-$row2[1];
					$flag = true;
					break;
				}

				$date = decrDay( $date );

				$ar = explode('-',$date);
				$year = $ar[0];
				$month = $ar[1];
				$day = $ar[2];
			}

			if( !flag )
				$count->$row1[0] = $row1[1];
		}

	}

	$sqlconn->close();
	return $count;
}

function totalApplnTillNow( $user )
{
	require_once "../../LocalSettings.php";
	require_once "../Globals.php";

	$sqlconn = new mysqli ( $eorgDBserver, $eorgDBuser, $eorgDBpasswd, $applnCount );

	$count = new stdClass();
	
	$type = countTypeOfAppln();
	$i = 0;

	while( $i < count($type) )
	{
		$qry = "SELECT * FROM $user WHERE $applnTy = $type[$i] ORDER BY $tillDate DESC limit 1";
		$result = $sqlconn->query($qry);
		
		$row = $result->fetch_array();
		
		$count->$row[0] = $row[1];
	}

	$sqlconn->close();
	return $count;
}

?>
