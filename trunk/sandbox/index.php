<?php
session_start();
 if(($_SESSION['valid']) == "valid") {
	header( 'Location: ./home.php' );
 }

//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: Mike Ellerhorst & Mark Pasquier
//  Fall 2008
//
// index.php - the entry/login page for the Disaster Database, if already logged in 
//				(session variable set) you will be redirected to home.php;
//****************************

include("config/functions.php");
include("html_include_1.php");
echo "<title>St. Joseph Red Cross - Disaster Database</title>";
include("html_include_2.php");
echo "<h1>St. Joseph Red Cross - Disaster Database</h1><br>";
	
$validlogin = $_SESSION['valid'];
//print "Session Variables: valid= ".$_SESSION['valid'].", user_id= ".$_SESSION['user_id']
//							.", access_level= ".$_SESSION['access_level_id']."<br><br>";
		
if ($validlogin == "invalid") {
	print "Invalid login, please try again.";
}

echo "<br>";
echo html_loginbox();
echo html_forgotuserpass();
?>
<br><br><br><br>
<p align="center">
       <a href="http://validator.w3.org/check?uri=referer">
         <img src="http://www.w3.org/Icons/valid-html401"
        alt="Valid HTML 4.01 Transitional" height="31" width="88" align="middle" >
    </a>
    <a href="http://jigsaw.w3.org/css-validator/check/referer">
        <img style="border:0;width:88px;height:31px"
            src="http://jigsaw.w3.org/css-validator/images/vcss" align="middle"
            alt="Valid CSS!" >
    </a>
    </p>
<?
include("html_include_3.php");
?>