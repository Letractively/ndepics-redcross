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

<!-- Search By Resource -->
<p name="resource_search">
<div align="center">
<h1 style="display: inline">Resource Search: </h1>
<form style="display: inline" name="resource_search" action="./search/searching.php" method="POST">
	<input type="hidden" name="search_type" value="resource">
	<input type="text" name="search_text" size="30" maxsize="100">
	<input type="submit" value="Search">
</form>
<br />
<br />
<hr />
</p>
</div>


<br /><div align = 'center'>
<form>
<INPUT TYPE="BUTTON" VALUE="Back" ONCLICK="window.location.href='javascript:history.back()'">
</form>
<br /></div>

<?
include ("./config/closedb.php");
include("html_include_3.php");
?>