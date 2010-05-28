<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Summer 2010 - Matt Mooney
// sitemap.php  - Page that links to all major "core" pages of the site
//****************************
session_start();
if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
}

include("config/functions.php");
include("html_include_1.php");
echo "<title>St. Joseph Red Cross - Disaster Database</title>";
echo "<script src=\"./javascript/selectorganization.js\"></script>";
include("html_include_2.php");
?>
<center><h2> Site Map </h2></center>
<hr>

<p>
<ul>
<li>Searching
	<ul>
    <li><a href="./search.php" title="Search the Database" target="_parent">Search</a>
    </ul>
<li>Add New Entries to the Database
	<ul>
    <li><a href="./addorganization.php" title="Add New Organization" target="_parent">Add Organization</a>
	<li><a href="./addperson.php" title="Add New Person" target="_parent">Add Person</a>
	<li><a href="./addresource1.php" title="Add New Resource" target="_parent">Add Resource</a>
    </ul>
<li>User Account Tools
	<ul>
    <li><a href="./newuser.php" title="Add New User" target="_parent">Create a User</a>
    <li><a href="./modifyuser.php" title="Add/Deny Permissions" target="_parent">Change User Permissions</a>
    <li><a href="./updateuser.php" title="Change My Account" target="_parent">Change My Information</a>
    <li><a href="./deleteuser.php" title="Delete User Account" target="_parent">Delete a User</a>
    </ul>
<li>General Database Tools
	<ul>
    <li><a href="./search/allresources.php" title="Full Resource List" target="_parent">Resource List</a>
    <li><a href="/csv/org_csv.php" title="Organization Table to CSV" target="_parent">Organization CSV</a>
    <li><a href="/csv/per_csv.php" title="Person Table to CSV" target="_parent">People CSV</a>
    <li><a href="/csv/res_csv.php" title="Resource Table to CSV" target="_parent">Resource CSV</a>
    </ul>
</ul>
</p>


<?
include("html_include_3.php");
?>

