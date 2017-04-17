
<?php


session_start();


//we have to change this session letter
if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && isset($_SESSION['PostName']) ) )
{
	echo "session id :".session_id()." ,You need to login as Admin to add users. Please log in as/contact Admin.";
		die();
}

$html1 = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<title>PostDashBoard</title>
<link rel="shortcut icon" href="/favicon.png" type="image/png">
<link rel="shortcut icon" type="image/png" href="../../image/gogreen.jpg" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body {
    
    background-image: url("../../image/photo14.jpg");
    
     min-height: 500px;
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}
button{

cursor: pointer; border:5px ; margin: 4px 2px; border:5px ; font-size : 25px; height:auto; width:auto ;background-color:#2a2a3c ;border:10px ;color:white;

}

</style>
</head>
<body>

HTML;

include 'Watch.php';
echo $html1;

$POST = $_SESSION['PostName'];

require '../Globals.php';
require '../../LocalSettings.php';

echo"";
echo "<center><b><i><h1 style = 'font-size:60px'>Hello $POST <h1></i></b><br>";



$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $eorgDBname );

if( $sqlConn->connect_errno ) 
{
	echo "Server error.";
	die();
}



$qry = "SELECT * FROM $PostTable WHERE $NameOfThePost = ?" ;
$stmt = $sqlConn->prepare( $qry );
$stmt->bind_param('s',$POST);
$stmt->execute();

$result = $stmt->get_result();
$row = mysqli_fetch_row($result);


if ( $row[1] == 'yes')
echo "<button  onclick= \"document.location.href='../AddUser.php' \"> ADD USER </button>";
if ( $row[2] == 'yes')
echo "<button  onclick=\"document.location.href='../RemoveUser.php' \"> DELETE USER </button> ";
if ( $row[3] == 'yes')
echo "<button  onclick=\"document.location.href='../AssignPost.php' \"> ASSIGN POST </button> ";
if ( $row[4] == 'yes')
echo "<button  onclick=\"document.location.href='../Post/CreatePost.php' \" >CREATE POST</button> ";
if ( $row[5] != 'no')
echo "<button onclick=\"document.location.href='../application/handleAppl.php'\"> HANDLE APPLICATION </button>";
if ( $row[6] != 'no')
echo "<button  onclick=\"document.location.href='../application/getUserApplnCount.php' \" > ACCESS USER DATABASE </button> ";



echo "<br><br><br><br><br><button  onclick=\"document.location.href='../postLogout.php' \">Log-Out !</button> ";
echo "<button  onclick=\"document.location.href='../AboutUs.php' \">ABOUT US</button> ";
echo "</center></body> </html>";

?>
