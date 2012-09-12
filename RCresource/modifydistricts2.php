<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Summer 2012 - Henry Kim
// modifydistricts2.php - file to insert an organization into the disaster database
//****************************
session_start(); //resumes active session
if(($_SESSION['valid']) != "valid") {  //check for credentials
	header( 'Location: ./index.php' ); //redirect to index if not loggin in
}
if( !(($_SESSION['access_level_id'] > 3) && ($_SESSION['access_level_id'] < 10))){ //ensure user has "add" rights
	header( 'Location: ./index.php' ); //redirect if not authorized
}
include("./config/dbconfig.php"); //database name and password
include("./config/opendb.php"); //opens connection
include("./config/functions.php"); //imports external functions
include("./html_include_1.php"); //open html tags
echo "<title>St. Joseph Red Cross - Modifying A Chapter</title>"; //print page title
include("html_include_2.php"); //rest of HTML header info

// This gets all the district_name in the districts table.
$districts_data = mysql_query("SELECT * FROM districts") or die("Error: Getting Districts");

$district_name_add = $_POST["district_name_add"];
if ($district_name_add != NULL){
	$district_add_error = False;
	while($districts = mysql_fetch_array($districts_data)){
		if($districts[district_name] == $district_name_add){
			$district_add_error = True;
			print "The district being added already exists. Please try again.<br />";
			$redirect_url = "modifydistricts.php";
			print "<meta http-equiv=\"Refresh\" content=\"1; url=".$redirect_url."\">";
		}
	}
}

// This gets all the district_name in the districts table.
$districts_data = mysql_query("SELECT * FROM districts") or die("Error: Getting Districts");

$district_name_remove = $_POST["district_name_remove"];
if ($district_name_remove != NULL){
	$district_remove_error = True;
	while($districts = mysql_fetch_array($districts_data)){
		if($districts[district_name] == $district_name_remove){
			$district_remove_error = False;
		}
	}
	if($district_remove_error == True){
		print "The district being removed does not exist. Please try again.<br />";
		$redirect_url = "modifydistricts.php";
		print "<meta http-equiv=\"Refresh\" content=\"1; url=".$redirect_url."\">";
	}
}

if ($district_add_error == False && $district_remove_error == False){
	if($district_name_add != NULL){
		print "Adding District: ".$district_name_add."<br />";
		$query = "INSERT INTO districts (district_name) VALUES (\"".$district_name_add."\")";
		$result = mysql_query($query) or die("Error: Adding District");
	}
	if($district_name_remove != NULL){
		print "Removing District: ".$district_name_remove."<br />";
		$query2 = "DELETE FROM districts WHERE district_name='".$district_name_remove."'";
		$result2 = mysql_query($query2) or die ("Error: Removing District");
	}

	// This prepares the query that is used to change all the chapters defined in the organization table.	
	$chapters_districts_query = "ALTER TABLE `organization` CHANGE `association` `association` SET(";
	// This gets all the chapter_name in the chapters table.
	$chapters_data = mysql_query("SELECT * FROM chapters") or die("Error: Getting Chapters");
		while($chapters = mysql_fetch_array($chapters_data)){
			$chapters_districts_query = $chapters_districts_query."'".$chapters[chapter_name]."',";
		}
	// This gets all the district_name in the districts table.
	$districts_data = mysql_query("SELECT * FROM districts") or die ("Error: Getting Districts");
		while($districts = mysql_fetch_array($districts_data)){
			$chapters_districts_query = $chapters_districts_query."'".$districts[district_name]."',";
		}
	$chapters_districts_query = $chapters_districts_query."'Region', 'State', 'National', 'Other' ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL";
	// This sets all the chapters defined in the organization table.
	$chapters_districts_result = mysql_query($chapters_districts_query) or die("Error: Setting Organization's Chapters and Districts");
	
	print "Redirecting...";		
	$redirect_url = "home.php";
	print "<meta http-equiv=\"Refresh\" content=\"0; url=".$redirect_url."\">";
}
	print '<form style="display: inline" action="modifychapters.php">';
		print '<input type="submit" value="Back" />';
	print '</form>';
	
include ("config/closedb.php");
include("html_include_3.php");
?>