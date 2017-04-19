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


$html = <<<HTML
<html>
<head>
<title>Assign Post(s)</title>
<link rel="shortcut icon" href="/favicon.png" type="image/png">
<link rel="shortcut icon" type="image/png" href="../image/gogreen.jpg" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>


body {
    color:white;
    background-image: url("../image/image4.jpg");
     min-height: 500px;
    background-attachment: fixed;
    background-position: center;
   font-size:30px;
    background-size: cover;
    background-repeat: no-repeat;
}
input[type=text] {
    width: 200px;
   height:35px;
   font-size:25px;
}
button
{
	cursor: pointer; font-size : 25px; height:auto; width:auto ;background-color:#000000;color:white ;
	border: 0.25px solid white;
}
</style><br>
</head>
<body>
HTML;

echo $html;

if ( $_SESSION['Username'] == 'admin')
{
echo "<button onclick=\"document.location.href='../' \"> HOME </button> ";
}
else
{
echo "<button onclick=\"document.location.href='dashboard/PostDashBoard.php'\"> HOME </button>";
}

echo "<center><b><i>";


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
	$newRow = preg_replace('/\s+/', '_', $row[0]);
	$newRow = str_replace('.', '$', $newRow);
	if( isset($_POST[$newRow]) )
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
			$stmt2->bind_param ('ss', $row[0], $_POST[$newRow] );
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
			$stmt2->bind_param ('s', $_POST[$newRow] );
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

echo "<br>Assigned successfully.<br><br>";
echo "<button onclick=\"document.location.href='AssignPost.php'\"> CREATE ANOTHER </button><br>";

echo "</body></html>";

?>
