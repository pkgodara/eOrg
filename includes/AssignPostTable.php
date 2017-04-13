<?php
/*
 *
 * This is to assign post(s) to the user(s)
 *
 */


session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && ( $_SESSION['Username'] == 'admin' || isset($_SESSION['PostName']) ) ) )
{
	echo "To access this page you need to login as Admin. Please log in first.";
	die();
}



require_once "../LocalSettings.php";
require_once "Globals.php";



$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $eorgDBname );

if( $sqlConn->connect_errno ) 
{
	echo "Error connecting database. Please check your database credentials and update.";
	die();
}

if(! isset($_POST['submit']))
{
	echo"Sorry, there is some problem";
	die();
}


$stmt = $sqlConn->prepare("CREATE TABLE IF NOT EXISTS $assignPostTable ($postTitle VARCHAR(100) NOT NULL, $assignedUser VARCHAR(100), INDEX idx USING BTREE ($postTitle))");
if ( ! $stmt->execute() )
{
	echo"there is a problem with database<br>";
	die ();
}
$stmt->close();



$stmt = $sqlConn->prepare("SELECT $NameOfThePost FROM $PostTable");

if ( ! $stmt->execute() )
{
	echo"there is a problem with database<br>";
	die ();
}



$res = $stmt->get_result();

while ($row = mysqli_fetch_row($res))
{
	if( ! empty($_POST[$row[0]]) )
	{
echo $row[0]."<br>";
		$stmtCheck = $sqlConn->prepare("SELECT $postTitle FROM $assignPostTable WHERE $postTitle = \"$row[0]\"");
		if ( ! $stmtCheck->execute() )
		{
			echo"there is a problem with database<br>";
			die ();
		}
		$resCheck = $stmtCheck->get_result();
		
		if($resCheck->num_rows == 0)
		{
			$stmt2 = $sqlConn->prepare("INSERT INTO $assignPostTable VALUES (?,?)");
			$stmt2->bind_param ('ss', $row[0], $_POST[$row[0]] );
			if ( ! $stmt2->execute() )
			{
				echo"there is a problem with database<br>";
				die ();
			}
			$stmt2->close();
		}
		else
		{
			$stmt2 = $sqlConn->prepare("UPDATE $assignPostTable SET $assignedUser = ? WHERE $postTitle = \"$row[0]\"");
			$stmt2->bind_param ('s', $_POST[$row[0]] );
			if ( ! $stmt2->execute() )
			{
				echo"there is a problem with database<br>";
				die ();
			}
			$stmt2->close();
		}
		$stmtCheck->close();
	}
}

echo "Assigned successfully<br><br>";
echo "<a href='AssignPost.php'>CREATE ANOTHER</a><br>";
echo "<a href='../'>HOME</a><br>";



?>
