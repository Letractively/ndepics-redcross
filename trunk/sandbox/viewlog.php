<?php
session_start();
// Validate the users's session
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
 }

 if( ($_SESSION['access_level_id'] < 1) || ($_SESSION['access_level_id'] > 10)){
 	header( 'Location: ./index.php' );
 }

// ****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: Mike Ellerhorst & Mark Pasquier
//  Spring 2009
//
// personinfo.php - Page to display information about a given person;
// ****************************

include ("./config/dbconfig.php");
include ("./config/opendb.php");
include ("./config/functions.php");

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Disaster Database - Personal Information</title>

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
  <div class="menu" align="center">
  <a href = "http://disaster.stjoe-redcross.org/sandbox/home.php" target= "_parent"> HOME</a> | 
  <a href = "http://disaster.stjoe-redcross.org/sandbox/search.php" target= "_parent"> SEARCH </a>
  </div>
</iframe>


<?php
//'
//IF YOU HAVE ACCESS CODE.....
 if( !(($_SESSION['access_level_id'] == 8) || ($_SESSION['access_level_id'] == 0) || ($_SESSION['access_level_id'] > 10) || ($_SESSION['access_level_id'] < 0))){
 
		print "<h1 align=\"center\">Change Log</h1><hr>";
		
		$log_type = $_GET['type'];
		$log_id = $_GET['id'];
		
		//print "Person_id: ".$person_id."<br>";
		if( $log_type == "person"){ 
			$query = "SELECT log FROM person WHERE person_id = ".$log_id;
		}
		if( $log_type == "organization"){ 
			$query = "SELECT log FROM organization WHERE organization_id = ".$log_id;
		}
		if( $log_type == "resource"){ 
			$query = "SELECT log FROM detailed_resource WHERE resource_id = ".$log_id;
		}
		
		
		$result = mysql_query($query) or die ("Query Failed...could not retrieve person's information");
		
		$row = mysql_fetch_assoc($result);
		
		/***** BUTTONS to Navigate ****/
		print "<div align=\"center\" name=\"navigation_buttons\">";
		
		print "<table>";
		print	"<tr>";
		print		"<td><form>";
		print 		"<INPUT TYPE=\"BUTTON\" VALUE=\"Back\" ONCLICK=\"window.location.href='javascript:history.back()'\">";
		print			"</form>";
		print		"</td>";
		
		// Home BUTTON
		print		"<td><form action=\"./home.php\">";
		print			"<input type=submit value='Home'>";
		print			"</form>";
		print		"</td>";
		
		print	"</tr>";
		print "</table>";
		
		print "</div>";
		
		/******/
		
		//
		// Display the Personal Information
		print "<br>".nl2br($row['log'])."<br>";
		
		mysql_free_result($result);
		
		print "<div align = 'center'>";
		print "<br><form>";
		print "<INPUT TYPE=\"BUTTON\" VALUE=\"Back\" ONCLICK=\"window.location.href='javascript:history.back()'\">";
		print "</form>";
		print "</div>";
		
		
		
		include ("./config/closedb.php");
}

//IF YOU ONLY HAVE INSERT PRIVELEDGES
else{

	print 	"<div align=\"center\">";
	print 	"<h2>You do not have permission to view logs.";
	print 	"<p>Thank You. </h2>";
	print		"<td><form action=\"./home.php\">";
	print			"<input type=submit value='Home'>";
	print			"</form>";
	print		"</td>";
	print	"</div";
}
?>

<p>
<p>
</div>

</body>
</html>
