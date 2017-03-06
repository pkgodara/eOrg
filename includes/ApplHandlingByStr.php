<?php


/*
 *
 * defining functions to handle applications such as approving , accepting , etc.
 * using the status-string of the aplocation stored in the database.
 *
 */


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
