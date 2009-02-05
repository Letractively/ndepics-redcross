<?php
session_start();
// Validate the users's session
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
 }
 if( ($_SESSION['access_level_id'] != 7)){
 	header( 'Location: ./index.php' );
 } 

//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: Mike Ellerhorst & Mark Pasquier
//  Fall 2008
//
// deleteperson.php - file that verifies that a person should be deleted;
//****************************

include ("config/dbconfig.php");
include ("config/opendb.php");
include ("config/functions.php");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><head>
<title>Disaster Database - Delete Person Record</title>
</head>


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
  <h1>Confirm Deletion of Person</h1>
</div>


<?php
//
// Get and display the person information

$person_id = $_POST['person_id'];

$query = "SELECT	*
		  FROM		person
		  WHERE		person_id = ".$person_id;
		  
$result = mysql_query($query) or die ("Person Query failed");

$row = mysql_fetch_assoc($result);

print "Are you sure you want to delete the person?<br>";

print "Name: ".$row['salutation']." ".$row['first_name']." ".$row['last_name']."<br>";

print "<table align=center>";
print "<tr>";

print "<td>";
print "<form action=\"./deleteperson2.php\" method=\"POST\" >";
print	"<input type=hidden name=person_id value=".$person_id.">";
print	"<input type=submit value='Delete Person'>";
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