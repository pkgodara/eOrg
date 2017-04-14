<?php

/* 
 * to change the password of the user
 */

session_start();

if( !( isset( $_SESSION['Username'] ) && isset($_SESSION['Name']) ) )
{
	echo "To access this page you need to login. Please log in first.";
	die();
}



$html = <<<HTML
<html>
<head>
<title>Reset Password</title>
</head>
<body>
<p>For reseting, you have to enter the previous password. Enter the password and verify</p>
<br><br>
<div id="oldPsswd">
Old Password :  <input id='oldPass' type='password' name='oldPassword' required>
<button type='button' name='verify' onclick='verifyPass(document.getElementById("oldPass").value)'>Verify</button>
</div>
<div id='errMsg'>
</div><br><br>
<div id='askNew'>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
function verifyPass (prev)
{
var xhttp;
xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function()
{
if (this.readyState == 4 && this.status == 200)
{
if (this.responseText === "1")
{
askNewPassword () ;
}
else if (this.responseText === "0")
{
document.getElementById("errMsg").innerHTML = "Sorry, your password didn't match. Enter again and click verify";
}
else
{
alert("Sorry, some unavoidable circumstance. Contact administration");
}
}
};
xhttp.open("POST", "verifyOldPassword.php", true);
xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xhttp.send("prev="+prev);
}
function askNewPassword ()
{
$("#oldPsswd").hide();
$("#errMsg").hide();
document.getElementById("askNew").innerHTML = "New Password : <input id='newPass' type='password' name='newPassword' required><br>Confirm new Password : <input id='cnfNew' type='password' name='cnfNewPassword' required><br>";
$("#askNew").append("<button type='button' onclick='carryForward()'>Change password</button>");
}
function carryForward()
{
var temp1 = document.getElementById("newPass").value ;
var temp2 = document.getElementById("cnfNew").value ;
var temp3 = document.getElementById("oldPass").value ;
isMatching(temp1, temp2, temp3);
}
function isMatching (newPass, cnfNew, old)
{
if (newPass != cnfNew)
{
alert("The entered passwords are not matching. Enter again");
}
else
{
var xhttp;
xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function()
{
if (this.readyState == 4 && this.status == 200)
{
document.getElementById("askNew").innerHTML = this.responseText;
}
};
xhttp.open("POST", "updatePassword.php", true);
xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xhttp.send("new="+newPass+"&cnfNew="+cnfNew+"&old="+old);
}
}
</script>
</body>
</html>
HTML;

echo $html;



?>
