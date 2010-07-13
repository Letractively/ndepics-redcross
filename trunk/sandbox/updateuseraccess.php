<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross
// Spring 2009 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// updateuseraccess.php - Page to change user permissions
//****************************
session_start(); //resumes active session
if(($_SESSION['valid']) != "valid") {  //check for credentials
	header( 'Location: ./index.php' ); //redirect to index if not loggin in
}
// Make sure the user is an admin
if($_SESSION['access_level_id'] != 9) {
	header( 'Location: ./index.php' ); //redirect if not authorized
} 
include("./config/dbconfig.php"); //database name and password
include("./config/opendb.php"); //opens connection
include("./config/functions.php"); //imports external functions
include("./html_include_1.php"); //open html tags
echo "<title>St. Joseph Red Cross - Update User Access</title>"; //print page title
include("./html_include_2.php"); //rest of html header information

//	Display the selected user's information and 
//	current access level in pre-populated checkboxes
print "User id: ".$_POST['user_id']."<br />";
if( $_POST['user_id'] == "NULL" ){
	print "<center><h3>You must select a user to modify.<br />";
	print "<form action=\"modifyuser.php\" method=\"post\">";
	print "<input type=\"submit\" value=\"Try Again\" />";
	print "</form></h3></center>";
}
else{
	$query = "	SELECT	u.username, u.email, al.*
				FROM	users u, access_level al
				WHERE	u.user_id = ".$_POST['user_id']."
				AND		u.access_level_id = al.access_level_id";
				
	$result = mysql_query($query) or die ("Error: Could not access the selected user's information");
	
	$row = mysql_fetch_assoc($result);
	
	print "<center><h2>".$row['username']."'s Access Rights</h2>";
	print " <h3>An administrative level grants all user abilities listed below.</h3>";
	
	print "<form action=\"updateuseraccess2.php\" method=\"post\">";
	
	print "<input type=\"hidden\" name=\"user_id\" value=".$_POST['user_id'].">";
	
	print "<table align=\"center\">";
	
	print "	<tr>";
	print "	<td><b>Admin</b></td>";
	print " <td><input type=\"checkbox\" name=\"admin\" value=\"1\" ".($row['Admin']?'checked="checked"':'')."></td>";
	print " </tr>";		
	
	print "	<tr>";
	print "	<td><b>Search</b></td>";
	print " <td><input type=\"checkbox\" name=\"search\" value=\"1\" ".($row['Search']?'checked="checked"':'')."></td>";
	print " </tr>";
	
	print "	<tr>";
	print "	<td><b>Insert</b></td>";
	print " <td><input type=\"checkbox\" name=\"insert\" value=\"1\" ".($row['Insert']?'checked="checked"':'')."></td>";
	print " </tr>";
			
	print "	<tr>";
	print "	<td><b>Delete</b></td>";
	print " <td><input type=\"checkbox\" name=\"delete\" value=\"1\" ".($row['Delete']?'checked="checked"':'')."></td>";
	print " </tr>";
			
	print "	<tr>";
	print "	<td><b>Update</b></td>";
	print " <td><input type=\"checkbox\" name=\"update\" value=\"1\" ".($row['Update']?'checked="checked"':'')."></td>";
	print " </tr>";		
	
	print "</table>";
	
	print "<br />";
	
	print "<input type=\"submit\" value=\"Update User\">";
	
	print "</form>";

}

include ("config/closedb.php"); //close database connection
include("html_include_3"); //close HTML tags
?>