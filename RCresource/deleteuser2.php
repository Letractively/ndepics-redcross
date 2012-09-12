<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2008 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// deleteuser2.php - Page to delete user from database
//****************************
session_start(); //resume current session
if(($_SESSION['valid']) != "valid") { //check for credentials
	header( 'Location: ./index.php' ); //redirect to index.php if not authorized
}
if($_SESSION['access_level_id'] != 9) { //ensure that user is an admin
        header( 'Location: ./index.php' ); //redirect if not authorized to manage users
} 

include ("./config/dbconfig.php");//database name and password
include ("./config/opendb.php");//connect to the database
include("config/functions.php");//import external functions
include("html_include_1.php");//Open HTML tags
echo "<title>St. Joseph Red Cross - Delete User</title>"; //print page title
include("html_include_2.php");//print rest of HTML header

//Pick up the POSTed input from deleteuser.php
$user_id = $_POST['user_id'];

//set redirection URL
$redirect_url = "./home.php";

//Delete user from database
$query = "DELETE	
		  FROM		users
		  WHERE		user_id = ".$user_id."
		  LIMIT		1";
$result = mysql_query($query) or die("There was an error deleting the user");
?>
<div align="center">
  <h1>Delete Person</h1>
</div>
<?
print "<br /><h2>User deleted</h2>";

print "<div align='center'>";
print "<form action=\"./home.php\">\n";
print "<input type=\"submit\" value=\"Return Home\">";
print "</form>\n";

include ("config/closedb.php"); //close database connection
include("html_include_3.php"); //close HTML tags
?>