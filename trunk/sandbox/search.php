<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2008 - Mike Ellerhorst & Mark Pasquier
// Fall 2009 - Rob Wettach
// Summer 2010 - Matt Mooney
// search.php - Page to launch ALL searches on database
//****************************
session_start(); //resumes active session
if(($_SESSION['valid']) != "valid") {  //check for credentials
	header( 'Location: ./index.php' ); //redirect to index if not loggin in
}
//Verify permission to search
if( ($_SESSION['access_level_id'] == 8) || ($_SESSION['access_level_id'] == 0) || ($_SESSION['access_level_id'] > 10) || ($_SESSION['access_level_id'] < 0)){
	header( 'Location: ./index.php' ); //redirect if no search rights
}
include("./config/dbconfig.php"); //database name and password
include("./config/opendb.php"); //opens connection
include("./config/functions.php"); //imports external functions
include("./html_include_1.php"); //open html tags
echo "<title>St. Joseph Red Cross - Search</title>"; //print page title
include("./html_include_2.php"); //rest of html header information

// Reset the search SESSION variables;
$_SESSION['search_type'] = '';
$_SESSION['search_text'] = '';

//Detailed variables
$_SESSION['detailed_search_name']	= '';
$_SESSION['detailed_search_city']	= '';
$_SESSION['detailed_search_state']	= '';
$_SESSION['detailed_search_zip']	= '';
$_SESSION['detailed_search_county'] = '';
?>
<!-- General Search Field -->
<p name="general_search">
<div align="center">
<h1 style="display: inline">General Search: </h1>
<form style="display: inline" name="general_search" action="./search/searching.php" method="POST">
	<input type="hidden" name="search_type" value="general">
	<input type="text" name="search_text" size="30" maxsize="100">
	<input type="submit" value="Search">
</form>
<br />
<br />
<hr />
</p>
</div>
<!-- Organization Searches -->
<p name="organization_search">
<h2>Search by Organization</h2>
<form name="organization_search" action="./search/searching.php" method="POST">
	
	<input type="hidden" name="search_type" value="organization">
	
	<b>General Organization Search: </b>
	<input type="text" name="search_text" size="30" maxsize="50">
	<input type="submit" value="Search Organizations">
	<br />Note: This scans the name, address, city, zip, and county, website, and email of the records.

</form>

<br />
<form name="detailed_organization_search" action="./search/searching.php" method="POST">

	<input type="hidden" name="search_type" value="detailed_organization">
	
	<b>Detailed Organization Search</b>
	<br />
	<table>
		<tr>
			<td width=20%></td>
			<td width=40%></td>
			<td width=40%></td>
		<tr>
		<td></td>
		<td>Organization Name: </td>
		<td><input type="text" name="detailed_search_name" maxsize="30"></td>
		</tr>
	
		<tr>
		<td></td>
		<td>City: </td>
		<td><input type="text" name="detailed_search_city" maxsize="30"></td>
		</tr>
		
		<tr>
		<td></td>
		<td>State: </td>
		<td><input type="text" name="detailed_search_state" size="2" maxsize="2"></td>
		</tr>
		
		<tr>
		<td></td>		
		<td>ZIP: </td>
		<td><input type="text" name="detailed_search_zip" size="10" maxsize="10"></td>
		</tr>
		
		<tr>
		<td></td>
		<td>County: </td>
		<td><input type="text" name="detailed_search_county" maxsize="30"></td>
		</tr>
		
		<tr>
		<td></td>
		<td><input type="submit" value="Detailed Search"></td>
		</tr>
		
	</table>
	
</form>
</p>
<br />

<!-- Search Organizations by resource provided -->
<hr />
<p name="resource_search">
<h2>Search by Resource</h2>
<form name="resource_search" action="./search/searching.php" method="POST">
	
	<input type="hidden" name="search_type" value="resource">
	<table>
		<tr>
		<td>Resource Keyword Search: </td>
		<td><input type="text" name="search_text" size="30" maxsize="50"></td>
		</tr>

<?
		print "<tr>";
		print "<td>Select a Resource: </td>";
		$query = "Select * from detailed_resource";
		$query .= " ORDER BY resource_type";
		
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
<br />

<!-- Search for organizations based on resource location -->
<p name="resource_city_search">
<h2>Search by Resource and City</h2>
<form name="resource_city_search" action="./search/searching.php" method="POST">
	
	<input type="hidden" name="search_type" value="resource_city">
	<table>
		<tr>
		<td>Resource Keyword Search: </td>
		<td><input type="text" name="search_text" size="30" maxsize="50"></td>
		</tr>
		<tr><td>Resource City: </td>
		<td><input type="text" name="search_city" size="30" maxsize="50"></td>
		</tr>
		<tr><td>Resource ZIP: </td>
		<td><input type="text" name="search_zip" size="30" maxsize="50"></td>
		</tr>
<?

		print "<tr>";
		print "<td>Select a Resource: </td>";
  
		$query = "Select * from detailed_resource";
		$query .= " ORDER BY resource_type";
		
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
	<input type="submit" value="Search Resources by City">
</form>
</p>
<br />


<!-- Person Search -->
<hr />
<p name="person_search">
<h2>Search by Person</h2>
<form name="person_search" action="./search/searching.php" method="POST">
	
	<input type="hidden" name="search_type" value="person">
	
	<b>General Person Search: </b>
	<input type="text" name="search_text" size="30" maxsize="50">
	<input type="submit" value="Search Persons">
	<br />Note: This scans the name, address, city, zip, phone numbers, and email of the records.

</form>
</p>

<br /><div align = 'center'>
<form>
<INPUT TYPE="BUTTON" VALUE="Back" ONCLICK="window.location.href='javascript:history.back()'">
</form>
<br /></div>

<?
include ("./config/closedb.php");
include("html_include_3.php");
?>