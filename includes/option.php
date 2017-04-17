<?php

session_start();


if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && ( $_SESSION['Username'] == 'admin' || isset($_SESSION['PostName']) ) ) )
{
	echo "session id :".session_id()." ,You need to login as Admin to add users. Please log in as/contact Admin.";
	die();
}



$html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<title>Add User</title>
<link rel="shortcut icon" href="/favicon.png" type="image/png">
<link rel="shortcut icon" type="image/png" href="../image/gogreen.jpg" />
</head>

<body style ="background-color:LightSlateGray" >

<br><br>
HTML;
echo"$html";

if ( $_SESSION['Username'] == 'admin')
{
echo "<button onclick=\"document.location.href='../' \"style='cursor: pointer; height:40px; width:100px'> HOME </button>";

}

else
{
echo "<button onclick=\"document.location.href='dashboard/PostDashBoard.php'\"style='cursor: pointer; height:40px; width:100px'> HOME </button>";
}
$html = <<<HTML
<h1 style = "text-align:center">
Please Enter Credentials.</h1>
<center>
<form action="UserAdd.php" method="post">


<table border = "15">

<caption style ="color:blue;text-align:center"><h1><b>WELCOME</b></h1></CAPTION>
<tr><th>Username :</th><td> <input type="text" name="user" required autofocus/> </td></tr>
<tr><th>Password : </th><td><input type="text" name="passwd" required/> </td></tr>
<tr><th>Full Name : </th><td><input type="text" name="fname" required/> </td></tr>
</table>
<br><br><b><big>SEX:::</b></big>
<input type ='radio' name ='sex' value ='Others'  style='height:20px; width:20px' ><b><big>OTHERS</b></big>
<input type ='radio' name ='sex' value ='Male'  style='height:20px; width:20px'><b><big>MALE</b></big>
<input type ='radio' name ='sex' value ='Female'  style='height:20px; width:20px'><b><big>FEMALE</b></big>
HTML;
echo"$html";

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
die();

}

else


{

echo "<h1>Categorize the users.</h1>";
echo "<b><big>Category::: </big></b>";

while ($row = mysqli_fetch_row($result))
{
$Str = str_replace('_',' ',$row[0]) ;
echo "<input type = 'radio' name = 'name[]' value = $row[0] onclick = 'TableFun( this )'  style='height:20px; width:20px'> <b><big>$Str</big></b> ";
}

echo"<hr>";


$h = <<<H
<div id ="table"></div>

<div id ="t"></div>
<br><br>



<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>





<script>


function TableFun(str) {
   
var xmlhttp = new XMLHttpRequest();

xmlhttp.onreadystatechange = function() {

if (this.readyState == 4 && this.status == 200) {

document.getElementById("table").innerHTML = this.responseText;

}


}



xmlhttp.open("POST", "TableDivision.php", true);

xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");       

xmlhttp.send("q="+str.value);
    
}






function FurtherCategorize(Table ,Str) {
   
var xmlhttp = new XMLHttpRequest();


xmlhttp.onreadystatechange = function() {


if (this.readyState == 4 && this.status == 200) {

$("#t").append("<br><br>"+this.responseText);

}
}

xmlhttp.open("POST", "Categorize.php", true);

xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");       

xmlhttp.send("q="+Table+"&f="+Str);
}



</script>

<input type ="submit"  value="SUBMIT" style='cursor: pointer; height:50px; width:200px'>
</form>
</center>
</body>
</html>
H;
echo"$h";

}
?>
