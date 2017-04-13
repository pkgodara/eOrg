<?php
/* 
 * Generate Login page
 */
session_start();

if( isset( $_SESSION['Username'] ) )
{
	if( $_SESSION['Username'] == 'admin' )
	{
		header("Location:includes/dashboard/Admin.php");
	}
	else
	{
		header("Location:includes/dashboard/User.php");
	}
	die();
}

$html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=.5">
<style>


body {
    
    background-image: url("nat.jpg");
    background-repeat: no-repeat;
}

</style>
<title>Login!</title>

</head>

<body>





<canvas id="canvas" width="200" height="200"
style="background-color:#80b3ff">
</canvas>
</center>
<script>
var canvas = document.getElementById("canvas");
var ctx = canvas.getContext("2d");
var radius = canvas.height / 2;
ctx.translate(radius, radius);
radius = radius * 0.90
setInterval(drawClock, 1000);

function drawClock() {
  drawFace(ctx, radius);
  drawNumbers(ctx, radius);
  drawTime(ctx, radius);
}

function drawFace(ctx, radius) {
  var grad;
  ctx.beginPath();
  ctx.arc(0, 0, radius, 0, 2*Math.PI);
  ctx.fillStyle = 'white';
  ctx.fill();
  grad = ctx.createRadialGradient(0,0,radius*0.95, 0,0,radius*1.05);
  grad.addColorStop(0, '#333');
  grad.addColorStop(0.5, 'white');
  grad.addColorStop(1, '#333');
  ctx.strokeStyle = grad;
  ctx.lineWidth = radius*0.1;
  ctx.stroke();
  ctx.beginPath();
  ctx.arc(0, 0, radius*0.1, 0, 2*Math.PI);
  ctx.fillStyle = '#333';
  ctx.fill();
}

function drawNumbers(ctx, radius) {
  var ang;
  var num;
  ctx.font = radius*0.15 + "px arial";
  ctx.textBaseline="middle";
  ctx.textAlign="center";
  for(num = 1; num < 13; num++){
    ang = num * Math.PI / 6;
    ctx.rotate(ang);
    ctx.translate(0, -radius*0.85);
    ctx.rotate(-ang);
    ctx.fillText(num.toString(), 0, 0);
    ctx.rotate(ang);
    ctx.translate(0, radius*0.85);
    ctx.rotate(-ang);
  }
}

function drawTime(ctx, radius){
    var now = new Date();
    var hour = now.getHours();
    var minute = now.getMinutes();
    var second = now.getSeconds();
    //hour
     hour=hour%12;
     hour=(hour*Math.PI/6)+
     (minute*Math.PI/(6*60))+
     (second*Math.PI/(360*60));
     drawHand(ctx, hour, radius*0.5, radius*0.07);
      //minute
    minute=(minute*Math.PI/30)+(second*Math.PI/(30*60));
      drawHand(ctx, minute, radius*0.8, radius*0.07);
     // second
          second=(second*Math.PI/30);
        drawHand(ctx, second, radius*0.9, radius*0.02);
                                                }
    
                                                function drawHand(ctx, pos, length, width) {
                                                    ctx.beginPath();
                                                        ctx.lineWidth = width;
                                                            ctx.lineCap = "round";
                                                                ctx.moveTo(0,0);
                                                                    ctx.rotate(pos);
                                                                        ctx.lineTo(0, -length);
                                                                            ctx.stroke();
                                                                                ctx.rotate(-pos);
                                                                                }
                                                                               </script>


































<center>
<h2>Please Enter your Login credentials.</h2>

<form action="includes/dashboard/Dashboard.php" method="post">


<table border = "15">

<caption style ="color:blue;text-align:center"><h1><b>WELCOME</b></h1></CAPTION>
<tr><th style = "color:white">Username  :</th><td> <input type="text" name="User" required/> </td></tr>
<tr><th style = "color:white">Password  : </th><td><input type="password" name="Passwd" required/> </td></tr>

</table>
<br><br><br><br>
<input  type="submit" name="login" value="Login!" style="cursor: pointer; font-size : 30px; height:auto; width:auto ;background-color: 	#000080 ;border:15px ;color:white" />
</form>
</centre>
</body>
</html>
HTML;

echo $html;


?>
