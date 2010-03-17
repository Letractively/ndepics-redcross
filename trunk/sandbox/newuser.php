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

include("config/functions.php");
include("html_include_1.php");
echo "<title>St. Joseph Red Cross - New User</title>";
echo "<script src=\"./javascript/selectorganization.js\"></script>";
include("html_include_2.php");

//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: ND Epics Group
//	    Mike Ellerhorst
//
//  Spring 2009
//
// newuser.php - File to show the input boxes to create a new user.
//
// Revision History:  02/04/09 - Created 
//					  02/24/09 - Updated menus and made password generation random.
//
//****************************
?>

<form name="newuser" method="post" action="newuser2.php" align ="left">

	<table>
		<tr>
		<td>Username</td>
		<td><input name="username" type="text" maxlength="50" align="left"> </td>
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

<? include("html_include_3.php"); ?>
