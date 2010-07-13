<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Summer 2010 - Matt Mooney
// sitemap.php  - Page that links to all major "core" pages of the site
//****************************
session_start(); //resumes active session
if(($_SESSION['valid']) != "valid") {  //check for credentials
	header( 'Location: ./index.php' ); //redirect to index if not loggin in
}

include("./config/dbconfig.php"); //database name and password
include("./config/opendb.php"); //opens connection
include("./config/functions.php"); //imports external functions
include("./html_include_1.php"); //open html tags
echo "<title>St. Joseph Red Cross - Site Map</title>"; //print page title
include("./html_include_2.php"); //rest of html header information
?>
<center><h2> Site Map </h2></center>
<hr />
<p>
<!-- Create list of links to key pages. -->
<!-- Lists are now XHTML formatted -->
<ul>
<li>Searching</li>
	<ul>
    <li><a href="./search.php" title="Search the Database" target="_parent">Search</a></li>
    </ul>
<li>Add New Entries to the Database</li>
	<ul>
    <li><a href="./addorganization.php" title="Add New Organization" target="_parent">Add Organization</a></li>
	<li><a href="./addperson.php" title="Add New Person" target="_parent">Add Person</a></li>
	<li><a href="./addresource1.php" title="Add New Resource" target="_parent">Add Resource</a></li>
    </ul>
<li>User Account Tools</li>
	<ul>
    <li><a href="./newuser.php" title="Add New User" target="_parent">Create a User</a></li>
    <li><a href="./modifyuser.php" title="Add/Deny Permissions" target="_parent">Change User Permissions</a></li>
    <li><a href="./updateuser.php" title="Change My Account" target="_parent">Change My Information</a></li>
    <li><a href="./deleteuser.php" title="Delete User Account" target="_parent">Delete a User</a></li>
    </ul>
<li>General Database Tools</li>
	<ul>
    <li><a href="./search/allresources.php" title="Full Resource List" target="_parent">Resource List</a></li>
    <li><a href="/csv/org_csv.php" title="Organization Table to CSV" target="_parent">Organization CSV</a></li>
    <li><a href="/csv/per_csv.php" title="Person Table to CSV" target="_parent">People CSV</a></li>
    <li><a href="/csv/res_csv.php" title="Resource Table to CSV" target="_parent">Resource CSV</a></li>
    </ul>
</ul>
</p>
<?
include("html_include_3.php"); //close HTML tags
?>

