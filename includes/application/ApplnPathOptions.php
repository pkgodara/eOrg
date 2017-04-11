<?php
/*
 *
 * This is to manage the application paths for different groups of the people.
 *
 */


session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && $_SESSION['Username'] === 'admin' ) )
{
	echo "To access this page you need to login as Admin. Please log in first.";
	die();
}



require_once "../../LocalSettings.php";
require_once "../Globals.php";



$sqlConnCat = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $catDB );

if( $sqlConnCat->connect_errno ) 
{
	echo "Error connecting database. Please check your database credentials and update.";
	die();
}

$tab = $_POST['tab'];
$levelId = $_POST['levelId'];
$catType = str_replace('L', 'C', $levelId);


$stmtCat = $sqlConnCat->prepare("SELECT * FROM $tab WHERE $levels REGEXP \"^$catType$\"");

if ( ! $stmtCat->execute() )
{
	echo"there is a problem with database<br>";
	die ();
}

$resCat = $stmtCat->get_result();

if ($resCat->num_rows == 0)
{
	echo "No further options available. Now, proceed for the further task(s)<br>";
}
else
{
	$catTypeName = mysqli_fetch_row($resCat);
	$lavelIdNew = $levelId."_[0-9]{1,}";
	$stmtCat2 = $sqlConnCat->prepare("SELECT * FROM $tab WHERE $levels REGEXP \"^$lavelIdNew$\"");
	if ( ! $stmtCat2->execute() )
	{
		echo"there is a problem with database<br>";
		die ();
	}

	$resCat2 = $stmtCat2->get_result();
	
$html = <<<HTML
<p>Now, if you want to go to further branching you can select the options from the dropdown, otherwise proceed without selecting anything</p>
<select name="$tab" onchange="giveFurtherOptions(this)">
<option value="" selected>Click to select the $catTypeName[1]</option>
HTML;

	echo $html;
	while ($rowCat2 = mysqli_fetch_row ($resCat2))
	{
		echo "<option value='$rowCat2[0]'>$rowCat2[1]</option>";
	}
	
	$stmtCat2->close();

}

echo "</select>";

$stmtCat->close();



?>
