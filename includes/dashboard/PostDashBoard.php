
<?php


session_start();

//if (!isset ($_POST['postName']))
//{



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
<style>


body {
    
    background-image: url("../../photo14.jpg");
    background-repeat: no-repeat;
}

</style>
</head>

<body>

HTML;

echo $html1;

$POST = $_SESSION['PostName'];

require '../Globals.php';
require '../../LocalSettings.php';


echo "<h1>Hello $POST<h1><br>";
echo "";//session post name latter


$sqlConn = new mysqli( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $eorgDBname );

if( $sqlConn->connect_errno ) 
{
	echo "Server error.";
	die();
}








$qry = "SELECT * FROM $PostTable WHERE $NameOfThePost = ?" ;
$stmt = $sqlConn->prepare( $qry );
$stmt->bind_param('s',$POST);
//$stmt->bind_param('s',$_POST['postName']);
$stmt->execute();

$result = $stmt->get_result();
$row = mysqli_fetch_row($result);

echo "<button onclick=\"document.location.href='../application/handleAppl.php'\"> Handle Applications </button>";

if ( $row[1] == 'yes')
{

echo "<button  onclick= \"document.location.href='../AddUser.php' \" style = '  cursor: pointer; border:5px ; margin: 4px 2px; border:5px ; font-size : 25px; height:auto; width:auto ;background-color:#3CB371 ;border:10px '> ADD USER </button>";

}




if ( $row[2] == 'yes')
{
echo "<button  onclick=\"document.location.href='../RemoveUser.php' \" style = '  cursor: pointer; border:5px ; margin: 4px 2px; border:5px ; font-size : 25px; height:auto; width:auto ;background-color:#3CB371 ;border:10px '> DELETE USER </button> ";
}


if ( $row[3] == 'yes')

{
echo "<button  onclick=\"document.location.href='../RemoveUser.php' \" style = ' cursor: pointer;  margin: 4px 2px; border:5px ; font-size : 25px; height:auto; width:auto ;background-color:#3CB371 ;border:10px '> ASSIGN POST </button> ";
}

if ( $row[4] == 'yes')
{

echo "<button  onclick=\"document.location.href='../RemoveUser.php' \" style = '  cursor: pointer; border:5px ; margin: 4px 2px; border:5px ; font-size : 25px; height:auto; width:auto ;background-color:#3CB371 ;border:10px '> HANDLE POST </button> ";

}

if ( $row[5] != 'no')
{
echo "<button  onclick=\"document.location.href='../RemoveUser.php' \" style = '  cursor: pointer; border:5px ; margin: 4px 2px; border:5px ; font-size : 25px; height:auto; width:auto ;background-color:#3CB371 ;border:10px '> ACCEPT APPLICATION</button> ";
}
if ( $row[6] != 'no')
{
echo "<button  onclick=\"document.location.href='../RemoveUser.php' \" style = '  cursor: pointer; border:5px ; margin: 4px 2px; border:5px ; font-size : 25px; height:auto; width:auto ;background-color:#3CB371 ;border:10px '> ACCESS USER DATABASE </button> ";
}
//}



echo "</body> </html>";

?>
