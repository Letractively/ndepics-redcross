<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross
// Spring 2009 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// viewlog.php - Page to view database change logs
//****************************
session_start();
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
 }
 if( ($_SESSION['access_level_id'] < 1) || ($_SESSION['access_level_id'] > 10)){
 	header( 'Location: ./index.php' );
 }

include ("./config/dbconfig.php");
include ("./config/opendb.php");
include("config/functions.php");
include("html_include_1.php");
echo "<title>St. Joseph Red Cross - Personal Information</title>";
include("html_include_2.php");

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
		print 		"<INPUT TYPE=\"BUTTON\" VALUE=\"Back\" 
						ONCLICK=\"window.location.href='javascript:history.back()'\">";
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
		
		// Display the Personal Information
		print "<br>".nl2br($row['log'])."<br>";
		
		mysql_free_result($result);
		
		print "<div align = 'center'>";
		print "<br><form>";
		print "<INPUT TYPE=\"BUTTON\" VALUE=\"Back\" 
					ONCLICK=\"window.location.href='javascript:history.back()'\">";
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
include ("./config/closedb.php");
include("html_include_3.php");
?>