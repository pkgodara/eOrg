<?php

$html = <<<HTML
<!DOCTYPE html>
<html>
<meta charset="UTF-8">

<link rel="shortcut icon" href="/favicon.png" type="image/png">
<link rel="shortcut icon" type="image/png" href="../image/gogreen.jpg" />
<title>About Us</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif}
</style>
<body class="w3-light-grey">
<br>

<div class="container">
  <br><br><br>
  <button type="button" onclick="document.location.href='../'"   class="btn btn-primary btn-block">HOME</button>


<br><br><br><br>
<!-- Page Container -->
<div class="w3-content w3-margin-top" style="max-width:1400px;">

  <!-- The Grid -->
  <div class="w3-row-padding">
  
    <!-- Left Column -->
    <div class="w3-third">
    
      <div class="w3-white w3-text-grey w3-card-4">
        <div class="w3-display-container">
          <img src="../image/gogreen.jpg" style="width:100%" alt="Avatar">
     <div class="w3-display-bottomleft w3-container w3-text-black">
          <br>
          <br>
          
         <center>    <h2><i><b> ...Go Paperless, Go Green </b></i></h2></center>
           
           
          </div>
        </div>
        <div class="w3-container">
       <hr><hr> <h3>Make Offices Digital and Efficient....</h3>
            <hr><hr>
             <img class="w3-round w3-margin-right" src="../image/home.png" style="width:25%;"><span class="w3-opacity w3-large"> IIT PATNA</span>
            <hr><hr>
              <img class="w3-round w3-margin-right" src="../image/email.png" style="width:25%;"><span class="w3-opacity w3-large"><h5><ul><li>           
              nabeel.bonvivant@gmail.com<li>deepakvermaasb@gmail.com<li>pkgodara.choudhary@gmail.com
              </ul></h5></span>
       <hr>
      <h2>Report a bug...</h2>
          <a href = "https://github.com/pkgodara/eOrg/issues"> Click Here..</a> 
        
        
        <br><br><br><br> <br><br><hr>
        </div>
      </div><br><hr>

    <!-- End Left Column -->
    </div>

    <!-- Right Column -->
    <div class="w3-twothird">
    
      <div class="w3-container w3-card-2 w3-white w3-margin-bottom">
        <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-suitcase fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>About eOrg</h2>
        <div class="w3-container">
       <h4><i> <center> eOrg is a free open source software intended to reduce loads of paperwork<br> done inter-organisational office-work.</center></i></h4>
          <hr>
        </div>
        <div class="w3-container">
           <h1 class="w3-text-grey w3-padding-16"><i class="fa fa-certificate fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Our Intensions :</h1>
      <h3> <ul><li>  To reduce paperwork in organisations as far as possible.

	<li>To build an enhanced structure for better application management within organisation.

	<li>Proficient and secure way to manage different types of documents/applications within an organisation.
</ul>
</h3>
          <hr>
        </div>
        <div class="w3-container">
       <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-certificate fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>License</h2>
    eOrg is distributed under the <a href = "https://opensource.org/licenses/MIT">MIT License.</a><br><br>
      </div>
      </div>

      <div class="w3-container w3-card-2 w3-white">
        <div class="w3-container">
           <img class="w3-round w3-margin-right" src="../image/aboutus.png" style="width:25%;"><span class="w3-opacity w3-large"></span>
     <div> <ul><li>
        NABEEL QAISER ,   CSE STUDENT AT IIT PATNA
      <li>
        PRADEEP KUMAR ,   CSE STUDENT AT IIT PATNA
       <li>
	DEEPAK VERMA  ,   CSE STUDENT AT IIT PATNA
        </ul>
        </div> <hr>  </div>
        <div class="w3-container">
      
 <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-certificate fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Want To Contribute...</h2>
      <h4>Fork the repository and commit/create pull requests in develop branch of eOrg.<br>
         </h4><a href = "https://github.com/pkgodara/eOrg">Click Here..</a> 
          </h4>
          
          <hr>
        </div>
        <div class="w3-container">
      
        </div>
      </div>

    <!-- End Right Column -->
    </div>
    
  <!-- End Grid -->
  </div>
  
  <!-- End Page Container -->
</div>
</div>
<footer class="w3-container w3-teal w3-center w3-margin-top">
<h2><b><i>
&copy  
HTML;
 
echo $html;
 echo date("Y");
$html = <<<HTML
  eOrg.
</h2>
 Fallow Us on GitHub.<br>
 <ul><a href = "https://github.com/dkasb">DEEPAK VERMA</a><br> 
 <a href = "https://github.com/NabeelQaiser">NABEEL QAISER</a><br> 
 <a href = "https://github.com/pkgodara">PRADEEP KUMAR</a> <br><br></ul>
 </footer>

</body>
</html>

HTML;
echo $html;





?>
