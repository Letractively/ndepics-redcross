<?php
session_start();
// Validate the users's session
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
 }

 if( ($_SESSION['access_level_id'] != 2) && ($_SESSION['access_level_id'] != 3) && ($_SESSION['access_level_id'] != 6) && ($_SESSION['access_level_id'] != 7) && ($_SESSION['access_level_id'] != 9)){
 	header( 'Location: ./index.php' );
 }

//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: Mike Ellerhorst & Mark Pasquier
//  Fall 2008
//
// deleteorganization.php - file that verifies that an organization should be deleted;
//****************************

include ("config/dbconfig.php");
include ("config/opendb.php");
include ("config/functions.php");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><head>
<title>Disaster Database - Delete Organization Record</title>

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

</head>


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
  <h1>Confirm Deletion of Organization</h1>
</div>


<?php
//
// Get and display the organization information

$organization_id = $_POST['organization_id'];

//print "Org_id: ".$organization_id."<br>";

$query = "SELECT	*
		  FROM		organization
		  WHERE		organization_id = ".$organization_id;
		  
$result = mysql_query($query) or die ("Organization Query failed");

$row = mysql_fetch_assoc($result);

print "Are you sure you want to delete the organization?<br>";

print "Name: ".$row['organization_name']."<br>";

print "<table align=center>";
print "<tr>";

print "<td>";
print "<form action=\"./deleteorganization2.php\" method=\"POST\" >";
print	"<input type=hidden name=organization_id value=".$organization_id.">";
print	"<input type=submit value='Delete Organization'>";
print "</form>";

print "</td>";

print "<td>";
print "<form>";
print "<INPUT TYPE=\"BUTTON\" VALUE=\"Back\" ONCLICK=\"window.location.href='javascript:history.back()'\">";
print "</form>";
print "</td>";

print "</tr>";
print "</table>";

print "<br";

include ("config/closedb.php");

?>


</div>
</body>
</html>