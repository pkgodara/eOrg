<?php

require 'Abbreviations.php';

$html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<title>Add User</title>

</head>

<body >

<h2>Please Enter Credentials.</h2>

<form action="UserAdd.php" method="post">


<table border = "15">

<caption style ="color:blue;text-align:center"><h1><b>WELCOME</b></h1></CAPTION>
<tr><th>Username :</th><td> <input type="text" name="user" required/> </td></tr>
<tr><th>Password : </th><td><input type="text" name="passwd" required/> </td></tr>
<tr><th>Full Name : </th><td><input type="text" name="fname" required/> </td></tr>
</table>
Designations : Student 
<br>
<select name ="std">
HTML;
echo"$html";

foreach ($AbbrDeg as $a )
{
echo"<option value =".$a.">".$DAbbrDeg[$a]."</option>";
}


$html1 = <<<HTML1
</select>
<select name = "dcpln">
HTML1;


echo "$html1";

foreach ($AbbrDept as $a ){
echo"<option value =".$a.">".$DAbbrDept[$a]."</option>";
}

$html2 = <<<HTML2
</select>
<br>
<select name = "batch">
<option value ="05">2005</option>
<option value ="06">2006</option>
<option value ="07">2007</option>
<option value ="08">2008</option>
<option value ="09">2009</option>
<option value ="10">2010</option> 
<option value ="11">2011</option>
<option value ="12">2012</option>  
<option value ="13">2013</option>
<option value ="14">2014</option>
<option value ="15">2015</option>
<option value ="16">2016</option>
<option value ="17">2017</option>
<option value ="18">2018</option>
<option value ="19">2019</option>
<option value ="20">2020</option>
<option value ="21">2021</option>
<option value ="22">2022</option>
<option value ="23">2023</option>
</select>
<br><input  type="submit" name="submit" value="Create User !" />
</form>
 
</body>
</html>
HTML2;

echo "$html2";
?>
