<?php
session_start();
// Validate the users's session
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
 }
 
 if( ($_SESSION['access_level_id'] == 8) || ($_SESSION['access_level_id'] == 0) || ($_SESSION['access_level_id'] > 10) || ($_SESSION['access_level_id'] < 0)){
 	header( 'Location: ./index.php' );
 } 

// ****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: Mike Ellerhorst & Mark Pasquier
//  Fall 2008
//
// search.php - the main search page for the Disaster Database;
// ****************************

include ("./config/dbconfig.php");
include ("./config/opendb.php");
include ("./config/functions.php");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Disaster Database - Search</title>



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
<h1>Search the Database</h1>
</div>

<hr>

<?php /*
<p name="general_search">
<h2> General Search (not yet, but soon)</h2>
<form name="general_search" action="./search/searchresults.php" method="POST">

	<input type="hidden" name="search_type" value="general">
	Search: <input type="text" name="general_search" size="30" maxsize="100">
	<input type="submit" value="Search">
</form>
</p>

*/ 
?>


<p name="organization_search">
<h2>Search by Organization</h2>
<form name="organization_search" action="./search/searchresults.php" method="POST">
	
	<input type="hidden" name="search_type" value="organization">
	
	<b>General Organization Search: </b>
	<input type="text" name="general_org_search" size="30" maxsize="50">
	<input type="submit" value="Search Organizations">
	<br>Note: This scans the name, address, city, zip, and county, website, and email of the records.

</form>

<form name="detailed_organization_search" action="./search/searchresults.php" method="POST">

	<input type="hidden" name="search_type" value="detailed_organization">
	
	<b>Detailed Organization Search</b>
	<br>
	<table>
		<tr>
			<td width=20%></td>
			<td width=40%></td>
			<td width=40%></td>
		<tr>
		<td></td>
		<td>Organization Name: </td>
		<td><input type="text" name="org_name_search" maxsize="30"></td>
		</tr>
	
		<tr>
		<td></td>
		<td>City: </td>
		<td><input type="text" name="org_city_search" maxsize="30"></td>
		</tr>
		
		<tr>
		<td></td>
		<td>State: </td>
		<td><input type="text" name="org_state_search" size="2" maxsize="2"></td>
		</tr>
		
		<tr>
		<td></td>		
		<td>ZIP: </td>
		<td><input type="text" name="org_zip_search" size="10" maxsize="10"></td>
		</tr>
		
		<tr>
		<td></td>
		<td>County: </td>
		<td><input type="text" name="org_county_search" maxsize="30"></td>
		</tr>
		
		<tr>
		<td></td>
		<td><input type="submit" value="Detailed Search"></td>
		</tr>
		
	</table>
	
</form>
</p>

<p name="resource_search">
<h2>Search by Resource</h2>
<form name="resource_search" action="./search/searchresults.php" method="POST">
	
	<input type="hidden" name="search_type" value="resource">
	<table>
		<tr>
		<td>Resource Keyword Search: </td>
		<td><input type="text" name="keyword_resource_search" size="30" maxsize="50"></td>
		</tr>

<?php

		print "<tr>";
		print "<td>Select a Resource: </td>";
  
		$query = "Select * from detailed_resource";

		$result = mysql_query($query) or die("Could not access resources");

		if( mysql_num_rows($result) < 1 )
		{
			print "There are no resources in the database, please go back and add a resource first!";
		}
		else 
		{
			print "<td><select name=\"resource_id\">";
			print "<option value=\"NULL\"> </option>";
		
			while( $row = mysql_fetch_assoc($result) )
			{
				print "<option value=\"".$row['resource_id']."\">".$row['resource_type']."</option>";
			}
		
			print "</select></td>";
		}
		
		print "</tr>";
?>
	
	</table>
	<input type="submit" value="Search Resources">
</form>
</p>

<br><div align = 'center'>
<form>
<INPUT TYPE="BUTTON" VALUE="Back" ONCLICK="window.location.href='javascript:history.back()'">
</form>
<br></div>

<?php
include ("./config/closedb.php");
?>

</div>
</body>
</html>