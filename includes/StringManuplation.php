<?php
/********************************************************
*function to find final designation 			*
*							*
*							*
*							*
*							*
*********************************************************/
function StringManuplation( $String )
{

$length = strlen($String);

$finalStr = "";

for($i = 2 ;$i < $length ;$i++)
{

	if($String[$i] == '_' )
	{	

$temp = substr($String ,0 , $i);
$finalStr = $finalStr.$temp.";";

	}
}

$finalStr = $finalStr.$String;
	
	return ($finalStr);
}
 
?>
