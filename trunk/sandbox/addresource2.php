<?php
session_start();
// Validate the users's session
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
 }
  if( ($_SESSION['access_level_id'] != 2) && ($_SESSION['access_level_id'] != 6) && ($_SESSION['access_level_id'] != 7) ){
 	header( 'Location: ./index.php' );
 } 

//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: Mike Ellerhorst & Mark Pasquier
//  Fall 2008
//
// addresource2.php - file to insert a resource into the disaster database;
//****************************

include ("config/functions.php");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><head><title>Welcome to the St. Joseph County Chapter American Red Cross - Disaster Database - Update Information</title>



<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="resource-type" content="document">
<meta name="description" content="disaster.stjoe-redcross.org">
<meta name="keywords" content="">
<meta name="copyright" content="stjoe-redcross.org 2008.  All rights reserved.">
<link rel="shortcut icon" href="http://www.stjoe-redcross.org/favicon.ico">

 <STYLE type="text/css">
  SPAN { padding-left:3px; padding-right:3px }
  DIV.header{ margin:0; padding-bottom: 1px; color: white; background-color: #000000; border:none; font-weight:bold}
  BODY.main{ width: 744px; margin:0 auto; padding:0; background-color:#003366; color: #000000; border:outset}
 </STYLE>


<body class="main">
<div style="border:2px solid white; background-color:#FFFFFF">

<iframe src ="homeframe.php" width="745px" height="175px" scrolling= "no" FRAMEBORDER="0">
  <h2 align="center">St. Joseph's County American Red Cross</h2>
  <p align="center">Your browser does not support iframes.</p>
  <div class="menu">
  <a href = "http://disaster.stjoe-redcross.org/sandbox/home.php" target= "_parent"> HOME</a> | 
  <a href = "http://disaster.stjoe-redcross.org/sandbox/search.php" target= "_parent"> SEARCH </a>
  </div>
</iframe>

<div align="center">
<c>
  <h1 align="center">Add Resource</h1>
<form>
<INPUT TYPE="BUTTON" VALUE="Back" ONCLICK="window.location.href='javascript:history.back()'">
</form>
</c>
</div>


<?php

$resource_type = $_POST["resource_type"];
$resource_description = $_POST["resource_description"];
$resource_keyword = $_POST["resource_keyword"];


//
// Scrub the inputs
$resource_type = scrub_input($resource_type);
$resource_description = scrub_input($resource_description);
$resource_keyword = scrub_input($resource_keyword);

//
// Display them for the user to verify

print "<p align='center'><b>Please verify this information.  If anything is incorrect, press the back button to return to the input form.</b></p>";

print "<form name='verifyresource' method='post' action='addresource3.php' align='left'>";
print "<input type=hidden name='resource_type' value=\"".$resource_type."\">";
print "<input type=hidden name='resource_description' value=\"".$resource_description."\">";
print "<input type=hidden name='resource_keyword' value=\"".$resource_keyword."\">";

print "<table>";
	print "<tr>";
	print "<td width=120><b> Resource Type: </b></td>";
	print "<td>".$resource_type."</td>";
	print "</tr>";

	print "<tr>";
	print "<td valign=\"top\"><b>Description: </b></td>";
	print "<td width=620>".$resource_description."</td>";
	print "</tr>";

	print "<tr>";
	print "<td><b>Keywords: </b></td>";
	print "<td>".$resource_keyword."</td>";
	print "</tr>";
print "</table><br>";
print "<div align='center'>";
print "<input type=submit value='Submit'>";
print "</div>";
print "</form>";

?>

<div align='center'>
<br><br>
<form>
<INPUT TYPE="BUTTON" VALUE="Back" ONCLICK="window.location.href='javascript:history.back()'">
</form>
</div>

</div>
</body>
</html>

