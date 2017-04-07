<?php 
/*********************************************************************************





**********************************************************************************/
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

require '../Globals.php';
require '../../LocalSettings.php';

$html = <<< html
<!DOCTYPE html >
<head>
</head>

<body style ="color:green ;background-color:yellow">

<form action ="Post.php" method ="post" >

POST NAME : <input type = "text"  name ="Pname"><br><br>
CAN ADD USER ? : <input type="radio" name="adduser" value="yes" >Yes
<input type="radio" name="adduser" value="no">No<br><br>

CAN DELETE USER ? :<input type="radio" name="delete" value="yes" > Yes
<input type="radio" name="delete" value="no"> No<br><br>

CAN ASSIGN POST ? :<input type="radio" name="assign_post" value="yes" > Yes
<input type="radio" name="assign_post" value="no"> No<br><br>

CAN HANDLE POST ? :<input type="radio" name="handle_post" value="yes" > Yes
<input type="radio" name="handle_post" value="no"> No<br><br>

CAN ACCEPT APPLICATION ?if not all then select whose?:
<input type ="radio" name="accept_application" value ="all" >All Users 
<input type="radio" name="accept_application" value="yes"  onclick = "WhoseApplication()" >Not All
<input type="radio" name="accept_application" value="no"> No<br><br>






<div id="accept_application">

</div>


<div id ="further">
</div>

<div id = "button">
</div>










<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<script>


function WhoseApplication() {

var xmlhttp = new XMLHttpRequest();

xmlhttp.onreadystatechange = function() {

if (this.readyState == 4 && this.status == 200) {
$("#accept_application").append("<br><br>"+this.responseText);


}


}



xmlhttp.open("POST", "find_user.php", true);

xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");       
 
xmlhttp.send();
   
}






function button(Str) {
   
var xmlhttp = new XMLHttpRequest();


xmlhttp.onreadystatechange = function() {


if (this.readyState == 4 && this.status == 200) {
document.getElementById("button").innerHTML = this.responseText;

}
}

xmlhttp.open("POST", "Button.php", true);

xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");       

xmlhttp.send("q="+Str);

}






function further_explore(Table , Str) {
   
var xmlhttp = new XMLHttpRequest();


xmlhttp.onreadystatechange = function() {


if (this.readyState == 4 && this.status == 200) {

$("#further").append("<br><br>"+this.responseText);

}
}

xmlhttp.open("POST", "Categorize1.php", true);

xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");       

xmlhttp.send("q="+Table+"&f="+Str);
}






function Done(Str) {
   
var xmlhttp = new XMLHttpRequest();


xmlhttp.onreadystatechange = function() {


if (this.readyState == 4 && this.status == 200) {
document.getElementById("button").innerHTML = this.responseText;


}
}

xmlhttp.open("POST", "Complete.php", true);

xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");       

xmlhttp.send("q="+Str);
}






function button1(Table ,Str) {
   
var xmlhttp = new XMLHttpRequest();


xmlhttp.onreadystatechange = function() {


if (this.readyState == 4 && this.status == 200) {
document.getElementById("button").innerHTML = this.responseText;



}
}

xmlhttp.open("POST", "Button1.php", true);

xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");       

xmlhttp.send("q="+Table+"&f="+Str);
}












</script>

<input type = "submit" name="SUBMIT">
</form->
</body>
</html>
html;

echo "$html";


?>


