<?php 
/*********************************************************************************





**********************************************************************************/
session_start();



if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && ( $_SESSION['Username'] == 'admin' || isset($_SESSION['PostName']) ) ) )

{
	echo "session id :".session_id()." ,You need to login as Admin to add users. Please log in as/contact Admin.";
	die();
}


require '../Globals.php';
require '../../LocalSettings.php';

$html = <<<html
<!DOCTYPE html >
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="/favicon.png" type="image/png">
<link rel="shortcut icon" type="image/png" href="../../image/gogreen.jpg" />
<style>
button,input[type=button],select
{
	cursor: pointer; font-size : 25px; height:auto; width:auto ;background-color:#6699FF;color:white ;
	border: 0.25px solid white;
}
</style><br
</head>

<body style ="background-color:#6699FF"><br><br>

html;

echo"$html";

if ( $_SESSION['Username'] == 'admin')
{
echo "<button onclick=\"document.location.href='../../'\" style='cursor: pointer; height:40px; width:150px;color:white ;background-color:#4B0082;font-size : 30px;' > HOME </button>";

}
else
{
echo "<button onclick=\"document.location.href='../dashboard/PostDashBoard.php'\" style='cursor: pointer; height:40px; width:150px;color:white ;background-color:#4B0082;font-size : 30px;' > HOME </button>";

}

$html = <<<HTML
<center>
<form action ="HandleFinalDataOfCreatePost.php" method ="post" >
<br><br><br><br><br><br>
<i><b>POST NAME : <input type = "text"  name ="Pname" pattern='[A-Za-z0-9. ]{1,}'  title='only alphabets, numbers and spaces and dot are allowed' required autofocus><br><br>

CAN ADD USER ? : <input type="radio" name="add_user" value="yes" >Yes
<input type="radio" name="add_user" value="no">No<br><br>

CAN DELETE USER ? :<input type="radio" name="delete_user" value="yes" > Yes
<input type="radio" name="delete_user" value="no"> No<br><br>

CAN ASSIGN POST ? :<input type="radio" name="assign_post" value="yes" > Yes
<input type="radio" name="assign_post" value="no"> No<br><br>

CAN HANDLE POST ? :<input type="radio" name="handle_post" value="yes" > Yes
<input type="radio" name="handle_post" value="no"> No<br><br>

CAN ACCEPT APPLICATION ?if not all then select whose?:
<input type ="radio" name="accept_application" value ="all"  onclick = "DocumentForCanAcceptAppl_HideEverithing()">All Users 
<input type="radio" name="accept_application" value ="yes"  onclick = "DocumentForCanAcceptAppl_WhoseApplication()" >Not All
<input type="radio" name="accept_application" value ="no" onclick = "DocumentForCanAcceptAppl_HideEverithing()"> No<br><br>








<div id="DocumentForCanAcceptAppl_acceptApplication">

</div>


<div id ="DocumentForCanAcceptAppl_further">
</div>

<div id = "DocumentForCanAcceptAppl_button">
</div>


<div id = "DocumentForCanAcceptAppl_termination">
</div>

<div id ="DocumentForCanAcceptAppl_backgroundId">
</div>





<br><br><br><br>
CAN ACCESS DATABASES OF USER ?if not all then select whose?:
<input type ="radio" name="canAccessDatabase" value ="all" onclick = "DocumentForCanAccessDatabaseOfUser_HideEverithing()" >All Users 
<input type="radio" name="canAccessDatabase" value="yes"  onclick = "DocumentForCanAccessDatabaseOfUser_WhoseApplication()" >Not All
<input type="radio" name="canAccessDatabase" value="no"  onclick = "DocumentForCanAccessDatabaseOfUser_HideEverithing()"> No<br><br>








<div id="DocumentForCanAccessDatabaseOfUser_accessDataBase">

</div>


<div id ="DocumentForCanAccessDatabaseOfUser_further">
</div>

<div id = "DocumentForCanAccessDatabaseOfUser_button">
</div>


<div id = "DocumentForCanAccessDatabaseOfUser_termination">
</div>

<div id ="DocumentForCanAccessDatabaseOfUser_backgroundId">
</div>


















<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<script>


function DocumentForCanAcceptAppl_HideEverithing(){
document.getElementById("DocumentForCanAcceptAppl_termination").innerHTML = "";
document.getElementById("DocumentForCanAcceptAppl_backgroundId").innerHTML = "";
document.getElementById("DocumentForCanAcceptAppl_acceptApplication").innerHTML = "";
document.getElementById("DocumentForCanAcceptAppl_further").innerHTML = "";
document.getElementById("DocumentForCanAcceptAppl_button").innerHTML = "";



}





function DocumentForCanAcceptAppl_WhoseApplication(){

var xmlhttp = new XMLHttpRequest();

xmlhttp.onreadystatechange = function() {

if (this.readyState == 4 && this.status == 200) {
$("#DocumentForCanAcceptAppl_acceptApplication").append("<br><br>"+this.responseText);


}


}



xmlhttp.open("POST", "CanAcceptAppl/DocumentForCanAcceptAppl_FindUser.php", true);

xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");       
 
xmlhttp.send();
   
}






function DocumentForCanAcceptAppl_button(Str) {
   
var xmlhttp = new XMLHttpRequest();


xmlhttp.onreadystatechange = function() {


if (this.readyState == 4 && this.status == 200) {
document.getElementById("DocumentForCanAcceptAppl_button").innerHTML = this.responseText;

}
}

xmlhttp.open("POST", "CanAcceptAppl/DocumentForCanAcceptAppl_Button.php", true);

xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");       

xmlhttp.send("q="+Str);

}






function DocumentForCanAcceptAppl_FurtherExplore(Table , Str) {
   
var xmlhttp = new XMLHttpRequest();


xmlhttp.onreadystatechange = function() {


if (this.readyState == 4 && this.status == 200) {

$("#DocumentForCanAcceptAppl_further").append("<br><br>"+this.responseText);

}
}

xmlhttp.open("POST", "CanAcceptAppl/DocumentForCanAcceptAppl_Categorize1.php", true);

xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");       

xmlhttp.send("q="+Table+"&f="+Str);
}






function DocumentForCanAcceptAppl_Done(Str) {

var xmlhttp = new XMLHttpRequest();


xmlhttp.onreadystatechange = function() {


if (this.readyState == 4 && this.status == 200) {
document.getElementById("DocumentForCanAcceptAppl_button").innerHTML = this.responseText;


}
}

xmlhttp.open("POST", "CanAcceptAppl/DocumentForCanAcceptAppl_Complete.php", true);

xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");       

xmlhttp.send("q="+Str);
}






function DocumentForCanAcceptAppl_button1(Table ,Str) {
   
var xmlhttp = new XMLHttpRequest();


xmlhttp.onreadystatechange = function() {


if (this.readyState == 4 && this.status == 200) {
document.getElementById("DocumentForCanAcceptAppl_button").innerHTML = this.responseText;



}
}

xmlhttp.open("POST", "CanAcceptAppl/DocumentForCanAcceptAppl_Button1.php", true);

xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");       

xmlhttp.send("q="+Table+"&f="+Str);
}







function DocumentForCanAcceptAppl_newPath(Str) {
$("#DocumentForCanAcceptAppl_backgroundId").hide(); 
$("#DocumentForCanAcceptAppl_backgroundId").append("<input type = 'text' name = 'canAccept[]'  value= '"+Str+"' readonly>");
document.getElementById("DocumentForCanAcceptAppl_acceptApplication").innerHTML = "";
document.getElementById("DocumentForCanAcceptAppl_further").innerHTML = "";
document.getElementById("DocumentForCanAcceptAppl_button").innerHTML = "";
document.getElementById("DocumentForCanAcceptAppl_termination").innerHTML = "Path added successfully";
DocumentForCanAcceptAppl_WhoseApplication();
}





function DocumentForCanAcceptAppl_terminate(Str) {
$("#DocumentForCanAcceptAppl_backgroundId").hide();
$("#DocumentForCanAcceptAppl_backgroundId").append("<input type = 'text' name = 'canAccept[]'  value = '"+Str+"' readonly>");
document.getElementById("DocumentForCanAcceptAppl_acceptApplication").innerHTML = "";
document.getElementById("DocumentForCanAcceptAppl_further").innerHTML = "";
document.getElementById("DocumentForCanAcceptAppl_button").innerHTML = "";
document.getElementById("DocumentForCanAcceptAppl_termination").innerHTML = "Path added successfully";
}













function DocumentForCanAccessDatabaseOfUser_HideEverithing(){
document.getElementById("DocumentForCanAccessDatabaseOfUser_termination").innerHTML = "";
document.getElementById("DocumentForCanAccessDatabaseOfUser_backgroundId").innerHTML = "";
document.getElementById("DocumentForCanAccessDatabaseOfUser_accessDataBase").innerHTML = "";
document.getElementById("DocumentForCanAccessDatabaseOfUser_further").innerHTML = "";
document.getElementById("DocumentForCanAccessDatabaseOfUser_button").innerHTML = "";


}











function DocumentForCanAccessDatabaseOfUser_WhoseApplication(){

var xmlhttp = new XMLHttpRequest();

xmlhttp.onreadystatechange = function() {

if (this.readyState == 4 && this.status == 200) {
$("#DocumentForCanAccessDatabaseOfUser_accessDataBase").append("<br><br>"+this.responseText);


}


}



xmlhttp.open("POST", "CanAccessDatabase/DocumentForCanAccessDatabaseOfUser_FindUser.php", true);

xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");       
 
xmlhttp.send();
   
}








function DocumentForCanAccessDatabaseOfUser_button(Str) {
   
var xmlhttp = new XMLHttpRequest();


xmlhttp.onreadystatechange = function() {


if (this.readyState == 4 && this.status == 200) {
document.getElementById("DocumentForCanAccessDatabaseOfUser_button").innerHTML = this.responseText;

}
}

xmlhttp.open("POST", "CanAccessDatabase/DocumentForCanAccessDatabaseOfUser_Button.php", true);

xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");       

xmlhttp.send("q="+Str);

}






function DocumentForCanAccessDatabaseOfUser_FurtherExplore(Table , Str) {
   
var xmlhttp = new XMLHttpRequest();


xmlhttp.onreadystatechange = function() {


if (this.readyState == 4 && this.status == 200) {

$("#DocumentForCanAccessDatabaseOfUser_further").append("<br><br>"+this.responseText);

}
}

xmlhttp.open("POST", "CanAccessDatabase/DocumentForCanAccessDatabaseOfUser_Categorize1.php", true);

xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");       

xmlhttp.send("q="+Table+"&f="+Str);
}







function DocumentForCanAccessDatabaseOfUser_Done(Str) {

var xmlhttp = new XMLHttpRequest();


xmlhttp.onreadystatechange = function() {


if (this.readyState == 4 && this.status == 200) {
document.getElementById("DocumentForCanAccessDatabaseOfUser_button").innerHTML = this.responseText;


}
}

xmlhttp.open("POST", "CanAccessDatabase/DocumentForCanAccessDatabaseOfUser_Complete.php", true);

xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");       

xmlhttp.send("q="+Str);
}






function DocumentForCanAccessDatabaseOfUser_button1(Table ,Str) {
   
var xmlhttp = new XMLHttpRequest();


xmlhttp.onreadystatechange = function() {


if (this.readyState == 4 && this.status == 200) {
document.getElementById("DocumentForCanAccessDatabaseOfUser_button").innerHTML = this.responseText;



}
}

xmlhttp.open("POST", "CanAccessDatabase/DocumentForCanAccessDatabaseOfUser_Button1.php", true);

xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");       

xmlhttp.send("q="+Table+"&f="+Str);
}







function DocumentForCanAccessDatabaseOfUser_newPath(Str) {
$("#DocumentForCanAccessDatabaseOfUser_backgroundId").hide(); 
$("#DocumentForCanAccessDatabaseOfUser_backgroundId").append("<input type = 'text' name = 'accessDataBase[]'  value= '"+Str+"' readonly >");
document.getElementById("DocumentForCanAccessDatabaseOfUser_accessDataBase").innerHTML = "";
document.getElementById("DocumentForCanAccessDatabaseOfUser_further").innerHTML = "";
document.getElementById("DocumentForCanAccessDatabaseOfUser_button").innerHTML = "";
document.getElementById("DocumentForCanAccessDatabaseOfUser_termination").innerHTML = "Path added successfully";
DocumentForCanAccessDatabaseOfUser_WhoseApplication();
}





function DocumentForCanAccessDatabaseOfUser_terminate(Str) {
$("#DocumentForCanAccessDatabaseOfUser_backgroundId").hide();
$("#DocumentForCanAccessDatabaseOfUser_backgroundId").append("<input type = 'text' name = 'accessDataBase[]'  value = '"+Str+"' readonly >");
document.getElementById("DocumentForCanAccessDatabaseOfUser_accessDataBase").innerHTML = "";
document.getElementById("DocumentForCanAccessDatabaseOfUser_further").innerHTML = "";
document.getElementById("DocumentForCanAccessDatabaseOfUser_button").innerHTML = "";
document.getElementById("DocumentForCanAccessDatabaseOfUser_termination").innerHTML = "Path added successfully";
}












</script>
<br><br><br><br><br><br><br><br><br><br><br>
<input type ="submit" name ="SUBMIT" style='cursor: pointer; height:50px; width:200px;color:white ;background-color:#4B0082;font-size : 30px;'/>
</i></b>
</form->
</center></body>
</html>
HTML;

echo "$html";


?>


