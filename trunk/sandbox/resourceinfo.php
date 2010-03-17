<?php
session_start();
// Validate the users's session
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
 }
 
 if( ($_SESSION['access_level_id'] < 1) || ($_SESSION['access_level_id'] > 10)){
 	header( 'Location: ./index.php' );
 }

//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: Mike Ellerhorst & Mark Pasquier
//  Fall 2008
//
// resourceinfo.php - Page to display information about a given resource;
//****************************

include ("./config/dbconfig.php");
include ("./config/opendb.php");
include("config/functions.php");include("html_include_1.php");echo "<title>St. Joseph Red Cross - Resource Information</title>";include("html_include_2.php");
?>
<?php
 if( !(($_SESSION['access_level_id'] == 8) || ($_SESSION['access_level_id'] == 0) || ($_SESSION['access_level_id'] > 10) || ($_SESSION['access_level_id'] < 0))){

		print "<h1 align=\"center\">Resource Information</h1><hr>";
		
		$resource_id = $_GET['id'];
		
		//print "Resource_id: ".$resource_id."<br>";
		
		$query = "SELECT * FROM detailed_resource WHERE resource_id = ".$resource_id;
		
		$result = mysql_query($query) or die ("Query Failed...could not retrieve resource information");
		
		$row = mysql_fetch_assoc($result);
		
		//
		// Navigation Buttons
		print "<div align=\"center\" name=\"navigation_buttons\">";
		
		print "<div align = 'center'>";
		print "<form>";
		print "<INPUT TYPE=\"BUTTON\" VALUE=\"Back\" ONCLICK=\"window.location.href='javascript:history.back()'\">";
		print "</form>";
		print "<br></div>";
		
		print "<table>";
		print	"<tr>";
		
		
		// Update BUTTON
		if( !(($_SESSION['access_level_id'] != 1) && ($_SESSION['access_level_id'] != 3) && ($_SESSION['access_level_id'] != 5) && ($_SESSION['access_level_id'] != 7) && ($_SESSION['access_level_id'] != 9)) )
		{
		print		"<td><form action=\"./updateresource.php\" method=\"POST\" >";
		print			"<input type=hidden name=resource_id value=".$resource_id.">";
		print			"<input type=submit value='Update Record'>";
		print			"</form>";
		print		"</td>";
		}
		
		
		// Delete BUTTON
		if( !(($_SESSION['access_level_id'] != 2) && ($_SESSION['access_level_id'] != 3) && ($_SESSION['access_level_id'] != 6) && ($_SESSION['access_level_id'] != 7) && ($_SESSION['access_level_id'] != 9)) )
		{
		print		"<td><form action=\"./deleteresource.php\" method=\"POST\" >";
		print			"<input type=hidden name=resource_id value=".$resource_id.">";
		print			"<input type=submit value='Delete Record'>";
		print			"</form>";
		print		"</td>";
		}
		
		// Home BUTTON
		print		"<td><form action=\"./home.php\">";
		print			"<input type=submit value='Home'>";
		print			"</form>";
		print		"</td>";
		
		print	"</tr>";
		print "</table>";
		
		print "</div>";
		
		//
		// Display the Resource Information
		print "<h3>".$row['resource_type']."</h3>";
		print "<table>";
		
		print	"<tr>";
		print		"<td>Description: </td>";
		print		"<td>".$row['description']."</td>";
		print	"</tr>";
		
		print	"<tr>";
		print		"<td>Keyword(s): </td>";
		print		"<td>".$row['keyword']."</td>";
		print	"</tr>";
		
		print "</table>";
		
		mysql_free_result($result);
		
		if( !(($_SESSION['access_level_id'] != 2) && ($_SESSION['access_level_id'] != 3) && ($_SESSION['access_level_id'] != 6) && ($_SESSION['access_level_id'] != 7) && ($_SESSION['access_level_id'] != 9)) )
		{
			print	"<div align = 'center'>";
			print	"<a href=\"./viewlog.php?id=".$resource_id."&type=resource\">View Log</a><br>";
			print	"</div>";
		}
		
		print "<div align = 'center'>";
		print "<br><form>";
		print "<INPUT TYPE=\"BUTTON\" VALUE=\"Back\" ONCLICK=\"window.location.href='javascript:history.back()'\">";
		print "</form>";
		print "</div>";
		
		
		include ("./config/closedb.php");
}
else{

	print 	"<div align=\"center\">";
	print 	"<h2>Resource Successfully Added.";
	print 	"<p>Thank You. </h2>";
	print		"<td><form action=\"./home.php\">";
	print			"<input type=submit value='Home'>";
	print			"</form>";
	print		"</td>";
	print	"</div";
}include("html_include_3.php");
?>