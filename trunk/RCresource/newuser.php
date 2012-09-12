<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2008 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// newuser.php - Page to create a new user for the site
//****************************
session_start(); //resumes active session
if(($_SESSION['valid']) != "valid") {  //check for credentials
	header( 'Location: ./index.php' ); //redirect to index if not loggin in
}
if($_SESSION['access_level_id'] != 9) { //make sure that the user is an admin
	header( 'Location: ./index.php' );
}
include("./config/dbconfig.php"); //database name and password
include("./config/opendb.php"); //opens connection to database
include("./config/functions.php"); //imports external functions
include("./html_include_1.php"); //open html tags
echo "<title>St. Joseph Red Cross - New User</title>"; //print page title
include("./html_include_2.php"); //rest of html header information
echo "<h1>New User</h1>";
?>
<form name="newuser" method="post" action="newuser2.php" align ="left">
	<table>
		<tr>
		<td>Username (limit, 15 chars)</td>
		<td><input name="username" type="text" maxlength="15" align="left"> </td>
		</tr>
		

		<tr>
		<td>Email</td>
		<td><input name="email" type="text" maxlength="50" align="left"> </td>
		</tr>
	</table>
	
	<table>
		<tr>
		<td><b>User Capabilities</b></td>
		</tr>
		
		<tr>
		<td>Admin</td>
		<td><input name="admin" type="checkbox" value="1"></td>
		<td>An administrative level grants all user abilities listed below.</td>
		</tr>
		
		<tr>
		<td>Search</td>
		<td><input name="search" type="checkbox" value="1"></td>
		</tr>
		
		<tr>
		<td>Insert</td>
		<td><input name="insert" type="checkbox" value="1"></td>
		</tr>
		
		<tr>
		<td>Delete</td>
		<td><input name="delete" type="checkbox" value="1"></td>
		</tr>
		
		<tr>
		<td>Update</td>
		<td><input name="update" type="checkbox" value="1"></td>
		</tr>
		
	</table>

	<br>
	<input type="submit" value="Create New User">
	<input type="reset" value="Clear Form">

</form>

<?
include("html_include_3.php");
?>