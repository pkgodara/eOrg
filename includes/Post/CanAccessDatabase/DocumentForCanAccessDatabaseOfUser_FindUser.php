<?php
/********************************************

this file will find out user from table for creat post

*********************************************/
session_start();


if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && $_SESSION['Username'] == 'admin' ) )

{
	echo "session id :".session_id()." ,You need to login as Admin to add users. Please log in as/contact Admin.";
	die();
}

else 
{


echo "yha per uska dena hi";




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


echo "<select name = 'level' onclick = 'DocumentForCanAcceptAppl_button( this.value )' >";


while ($r = mysqli_fetch_row($result))

                {
                echo "<option value= $r[0]  >$r[0]</option>";
		}
echo"</select>";

}



?>
