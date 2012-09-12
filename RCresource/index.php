<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2008 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// index.php - Default page: Login or redirect if authenticated
//****************************
session_start(); //start or resume active session
if(($_SESSION['valid']) == "valid") { //if already logged in
	header( 'Location: ./home.php' ); //redirect to the homepage
}

include("./config/dbconfig.php"); //database name and password
include("./config/opendb.php"); //opens connection to database
include("./config/functions.php"); //imports external functions
include("./html_include_1.php"); //open html tags
echo "<title>St. Joseph Red Cross Disaster Database</title>"; //print page title
include("./html_include_2.php"); //rest of html header information
echo "<h1>St. Joseph Red Cross Disaster Database</h1><hr /><br />";

$validlogin = $_SESSION['valid']; //grab new session
if ($validlogin == "invalid") { //if session is not marked as valid. Login again.
	print "Invalid login, please try again.";
}

echo "<br />";
echo html_loginbox(); //print the login box
echo html_forgotuserpass(); //print the forgot password link
?>
<br /><br /><br /><br />
<p align="center">
<table align="center">
<tr><td>

       <a href="http://validator.w3.org/check?uri=referer">
         <img src="http://www.w3.org/Icons/valid-html401"
        alt="Valid HTML 4.01 Transitional!" height="31" width="88" align="middle" >
    </a>
</td>
<td>
    <a href="http://jigsaw.w3.org/css-validator/check/referer">
        <img style="border:0;width:88px;height:31px"
            src="http://jigsaw.w3.org/css-validator/images/vcss" align="middle"
            alt="Valid CSS!" >
    </a>
</td>
</tr>
</table>
    </p>
<?
include("./config/closedb.php"); //close database connection
include("./html_include_3.php"); //close HTML tags
?>