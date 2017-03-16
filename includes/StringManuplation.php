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
$t =",";
$k = 1;
$str = "";
for($i = 0 ;$i < $length ;$i++ )
{
	
for($j = 0 ;$j <= $k  ;$j++  )
{
 if($k < $length)
 {
$str = $str.$String[$j] ;
 }
}
 if($k < $length - 1)
 {
$str = $str.$t ;
	 }
$k++;

}
 
return ($str);
}
 
?>
