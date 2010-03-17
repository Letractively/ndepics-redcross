<?php
session_start();
// Validate the users's session
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
 }
// Make sure the user is an admin
 if($_SESSION['access_level_id'] != 9) {
        header( 'Location: ./index.php' );
 } 

//****************************
//  Developed by ND Epics for St. Joe County Red Cross 
//  
// Authors: Mike Ellerhorst 
//  Spring 2009
//
// deleteuser.php - admin only page that deletes a user and redirects home or displays error message
//
// Revision History:  02/24/09 - Created
//
//****************************

include ("config/dbconfig.php");
include ("config/opendb.php");

include("config/functions.php");
include("html_include_1.php");
echo "<title>St. Joseph Red Cross - Delete User</title>";
echo "<script src=\"./javascript/selectorganization.js\"></script>";
include("html_include_2.php");
//
// Delete the user passed from the previous page and if successful, redirect home.
//	Else, display error message and give option to go home or back.

$redirect_url = "./home.php";
$user_id = $_POST['user_id'];

$query = "DELETE	
		  FROM		users
		  WHERE		user_id = ".$user_id."
		  LIMIT		1";
		  
$result = mysql_query($query);

?>

<div align="center">
  <h1>Delete Person</h1>
</div>


<?php

//'
// Error Deleting user
// 

print "<center><h2>There was an error deleting the user. Please try again.</h2></center>";

print "<div align='center'>";
print "<form action=\"./home.php\">\n";
print "<input type=\"submit\" value=\"Return Home\">";
print "</form>\n";

print "<form>\n";
print "<input type=\"button\" value=\"Back\" onClick=\"window.location.href='javascript:history.back()'\">";
print "</form>\n";
print "</div><br>";

include ("config/closedb.php");
include("html_include_3.php");
?>