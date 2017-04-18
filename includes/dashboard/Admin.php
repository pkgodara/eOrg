<?php

/* 
 * dashboard for admin
 */
session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) && $_SESSION['Username'] === 'admin' ) )
{
	echo "To access this page you need to login as Admin. Please log in first.";
	die();
}

$html1 = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<title>Admin</title>

<link rel="shortcut icon" href="/favicon.png" type="image/png">
<link rel="shortcut icon" type="image/png" href="../../image/gogreen.jpg" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>


body {
    color:white;
    background-image: url("../../image/adminpic.jpg");
     min-height: 500px;
    background-attachment: fixed;
    background-position: center;
   
    background-size: cover;
    background-repeat: no-repeat;
}
table, td, th {
    text-align:center;
    border: 1px solid black;
}

table {
    width: 100%;
    border-color: white;
}

th {
    height: 50px;
}

button, select
{
	cursor: pointer; font-size : 25px; height:auto; width:auto ;background-color:#000000;color:white ;
	border: 0.25px solid white;
}
</style>
<title>Admin</title>

</head>

<body style = "font-size:25px">

HTML;
echo $html1;
include 'Watch.php';


$html2 = <<<HTML
<center><b><i>
<br><br><br><br>
<h2>Hello

HTML;
echo $html2;
echo " ".$_SESSION['Name'];
$html2 = <<<HTML


</h2>
<br><br><br><br>

<button onclick="document.location.href='../modifyCat.php'" > Modify category(s) </button>
<button onclick="document.location.href='../Post/CreatePost.php' "> Create Post </button>
<button onclick="document.location.href='../Post/DeletePost.php' "> Delete Post </button>
<button onclick="document.location.href='../application/createApplnType.php'" > Create a type of application </button>
<button onclick="document.location.href='../application/ApplnPaths.php'" > Create path(s) of Application </button>
<br><br>
<button onclick="document.location.href='../AssignPost.php'"> Assign a POST </button>
<button onclick="document.location.href='../AddUser.php'" > Add User </button>
<button onclick="document.location.href='../EditUser.php'"> Edit User </button>
<button onclick="document.location.href='../RemoveUser.php'"> Remove User </button>
<br><br>
<button onclick="document.location.href='../Logout.php'"> Log out ! </button>
<button onclick='showTheUsers()'>View Users</button>
<div id='showHere'></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
function showTheUsers()
{
var xhttp;
xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function()
{
if (this.readyState == 4 && this.status == 200)
{
document.getElementById("showHere").innerHTML = this.responseText;
}
};
xhttp.open("POST", "viewUsers.php", true);
xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xhttp.send();
}
function viewUserDesign(userId, groupId)
{
var xhttp;
xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function()
{
if (this.readyState == 4 && this.status == 200)
{
document.getElementById(userId).innerHTML = this.responseText;
}
};
xhttp.open("POST", "viewuserDesign.php", true);
xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xhttp.send("desigId="+groupId);
}
function startAskingOptions (opted)
{
$("#backGround").hide();
var result = opted.split(",");
document.getElementById("backGround").innerHTML = result[1]+";";
var xhttp;
xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function()
{
if (this.readyState == 4 && this.status == 200)
{
document.getElementById("askUserOptions").innerHTML = this.responseText;
}
};
xhttp.open("POST", "FurtherUserOptions.php", true);
xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xhttp.send("tab="+result[0]+"&levelId="+result[1]);
}
function continueAskingOptions(table, levId)
{
$("#backGround").hide();
$("#backGround").append(levId+";");
var xhttp;
xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function()
{
if (this.readyState == 4 && this.status == 200)
{
document.getElementById("askUserOptions").innerHTML = this.responseText;
}
};
xhttp.open("POST", "FurtherUserOptions.php", true);
xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xhttp.send("tab="+table+"&levelId="+levId);
}
function showSelectedGroup (opted)
{
if( opted && opted != "\\n" )
{
var xhttp;
xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function()
{
if (this.readyState == 4 && this.status == 200)
{
document.getElementById("users").innerHTML = this.responseText;
}
};
xhttp.open("POST", "showSelectedGroup.php", true);
xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xhttp.send("groupId="+opted);
}
else
{
$("#askUserOptions").append("You need to select somthing first. ");
}
}
</script>
HTML;

echo $html2;




echo "</i></b></center></body> </html>";

?>
