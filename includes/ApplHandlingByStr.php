<?php


/*
 *
 * defining functions to handle applications such as approving , accepting , etc.
 * using the status-string of the aplocation stored in the database.
 *
 */


function showStatus( $stat_str )
{
	$STR = explode ( ';', $stat_str );
	for ( $i =  1;  $i < count ( $STR ) ; $i++ )
	{
		$str = explode ( ',', $STR[$i] );
		
		
		if( $str[1] == 'P' )
		{
			echo "<td><b>PENDING</b> by ".$str[0]."</td>";
			break;
		}
		else if( $str[1] == 'A' )
		{
			echo "<td><b>APPROVED</b> by ".$str[0] ."</td>";
		}
		else if( $str[1] == 'Y' )
		{
			echo "<td><b>ACCEPTED</b> by ".$str[0] ."</td>";
		}
		else if( $str[1] == 'R' )
		{
			echo "<td><b>REJECTED</b> by ".$str[0] ."</td>";
			break;
		}
		else if( $str[1] == 'F' )
		{
			echo "<td><b>FORWARDED</b> from ".$str[0]."</td>";
		}
		else
		{
			echo "<td><b>Unknown Status</b></td>";
		}
	}
}


function showFullStatus( $stat_str )
{
	$STR = explode ( ';', $stat_str );
	for ( $i =  0;  $i < count ( $STR ) ; $i++ )
	{
		$str = explode ( ',', $STR[$i] );
		
		
		if( $str[1] == 'P' )
		{
			echo "<td><b>PENDING</b> by ".$str[0]."</td>";
		}
		else if( $str[1] == 'A' )
		{
			echo "<td><b>APPROVED</b> by ".$str[0] ."</td>";
		}
		else if( $str[1] == 'Y' )
		{
			echo "<td><b>ACCEPTED</b> by ".$str[0] ."</td>";
		}
		else if( $str[1] == 'R' )
		{
			echo "<td><b>REJECTED</b> by ".$str[0] ."</td>";
			break;
		}
		else if( $str[1] == 'F' )
		{
			echo "<td><b>FORWARDED</b> from ".$str[0]."</td>";
		}
		else if( $str[1] == 'G' )
		{
			echo "<td><b>GENERATED</b> by ".$str[0] ."</td>";
		}
		else
		{
			echo "<td><b>Unknown Status</b></td>";
		}
	}
}


function findPending( $stat_str )
{
	$STR = explode ( ';', $stat_str );
	for ( $i =  1;  $i < count ( $STR ) ; $i++ )
	{
		$str = explode ( ',', $STR[$i] );
		$usr = $str[0];
		
		if( $str[1] == 'P' )
		{
		echo $usr;
			return $usr;
		}
	}
}


function needAcceptor($status)
{
	$str = explode ( ';', $status );
	for ( $i =  1;  $i < count ( $str )-1 ; $i++ )
	{
		$st = explode ( ',', $str[$i] )[1];
		
		if( $st == 'P' )
		{
			return false;
		}
	}
	
	if( explode(',', $str[ count($str)-1 ] )[1] == 'P' )
	{
		return true;
	}
	
	return false;
}

function needApprover($status)
{
	$str = explode ( ';', $status );
	for ( $i =  1;  $i < count ( $str )-1 ; $i++ )
	{
		$st = explode ( ',', $str[$i] )[1];
		
		if( $st == 'P' )
		{
			return true;
		}
	}
	
	return false;
}


function str_isApproved ( $stat_str, $user )
{

	$STR = explode ( ';', $stat_str );
	for ( $i =  1;  $i < count ( $STR ) ; $i++ )
	{
		$str = explode ( ',', $STR[$i] );
		if ( strcmp ( $user, $str[0] ) == 0 )
			if ( $str[1] == 'A' )
				return true;
			else
				return false;
	}
	return false;
}



function str_isRejected ( $stat_str, $user )
{

	$STR = explode ( ';', $stat_str );
	for ( $i =  1;  $i < count ( $STR ) ; $i++ )
	{
		$str = explode ( ',', $STR[$i] );
		if ( strcmp ( $user, $str[0] ) == 0 )
			if ( $str[1] == 'R' )
				return true;
			else
				return false;
	}
	return false;
}



function str_isAccepted ( $stat_str, $user )
{
	$STR = explode ( ';', $stat_str );
	for ( $i = 1 ;  $i < count ( $STR ) ; $i++ )
	{
		$str = explode ( ',', $STR[$i] );
		if ( strcmp ( $user, $str[0] ) == 0 )
			if ( $str[1] == 'Y' )
				return true;
			else
				return false;
	}
	return false;
}


function str_isForwarded( $stat_str, $user )
{
	$STR = explode ( ';', $stat_str );
	for ( $i = 1 ;  $i < count ( $STR ) ; $i++ )
	{
		$str = explode ( ',', $STR[$i] );
		if ( strcmp ( $user, $str[0] ) == 0 )
			if ( $str[1] == 'F' )
				return true;
			else
				return false;
	}
	return false;
}


function str_approve ( $stat_str, $user )
{
	$STR = explode ( ';', $stat_str );
	$new_str = $STR[0];
	$flag = 0;
	for ( $i = 1 ; $i < count ( $STR ) ; $i++ )
	{
		$str = explode ( ',', $STR[$i] );
		if ( strcmp ( $str[0], $user ) == 0 )
		{
			$flag = 1;
			if ( $str[1] == 'P' )
			{
				$str[1] = 'A';
				$STR[$i] = $str[0].",".$str[1];
			}
		}
		$new_str = $new_str.";".$STR[$i];
	}
	if ( $flag == 1 )
		return $new_str;
	else
		return false;
}



function str_accept ( $stat_str, $user )
{
	$STR = explode ( ';', $stat_str );
	$new_str = $STR[0];
	$flag = 0;
	for ( $i = 1 ; $i < count ( $STR ) ; $i++ )
	{
		$str = explode ( ',', $STR[$i] );
		if ( strcmp ( $str[0], $user ) == 0 )
		{
			$flag = 1;
			if ( $str[1] == 'P' )
			{
				$str[1] = 'Y';
				$STR[$i] = $str[0].",".$str[1];
			}
		}
		$new_str = $new_str.";".$STR[$i];
	}
	if ( $flag == 1 )
		return $new_str;
	else
		return false;
}



function str_isGenerator ( $stat_str, $user )
{
	$STR = explode ( ';', $stat_str );
	$str = explode ( ',', $STR[0] );
	if ( strcmp ( $user, $str[0] ) == 0 )
		return true;
	else
		return false;
}



function str_isApprover ( $stat_str, $user )
{
	$STR = explode ( ';', $stat_str );
	for ( $i = 1 ; $i < ( count($STR) - 1 ) ; $i++ )
	{
		$str = exolode ( ',', $STR[$i] );
		if ( strcmp ( $user, $str[0] ) == 0 )
			return true;
	}
	return false;
}




function str_isAccepter ( $stat_str, $user )
{
	$STR = explode ( ';', $stat_str );
	$str = explode ( ',', $STR[ count($STR) - 1 ] );
	if ( strcmp ( $user, $str[0] ) == 0 )
		return true;
	else
		return false;
}



?>
