<?php
/********************************************

this file will find out user from table for creat post

*********************************************/
session_start();


if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && ( $_SESSION['Username'] == 'admin' || isset($_SESSION['PostName']) ) ))

{
	echo "session id :".session_id()." ,You need to login as Admin to add users. Please log in as/contact Admin.";
	die();
}



require '../../Globals.php';
require '../../../LocalSettings.php';



$sqlConn = new mysqli ( $eorgDBserver , $eorgDBuser , $eorgDBpasswd , $catDB );


if( $sqlConn->connect_errno ) 
{
	echo "Error connecting database. Please check your database credentials and update.";
	die();
}



$qry = 'SELECT table_name FROM information_schema.tables WHERE table_schema = ?';//select all table from a data bases

$stmt = $sqlConn->prepare($qry);


$stmt->bind_param('s',$catDB);

$stmt->execute();

$result = $stmt->get_result();



if( $result->num_rows == 0  )//find number of rows in result object

{

echo "PLESE FIRST CATEGORIZE THE USER AND THE PROCEED AGAIN<br>THANK YOU!!";
echo "error in creating post !!!!!!!!!";
die();

}

else


{


echo "<select name = 'level' onclick = 'DocumentForCanAccessDatabaseOfUser_button( this.value )' >";
echo "<option value = ''  > SELECT</option>";
while ($r = mysqli_fetch_row($result))

                {
                $Str = str_replace('_',' ',$r[0]) ;
                echo "<option value= $r[0]  >$Str</option>";
		}
echo"</select>";

}



?>
