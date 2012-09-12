<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2008 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// Summer 2012 - Henry Kim
// home.php - Homepage
//****************************
session_start(); //resumes active session
if(($_SESSION['valid']) != "valid") {  //check for credentials
	header( 'Location: ./index.php' ); //redirect to index if not loggin in
}
include("./config/dbconfig.php"); //database name and password
include("./config/opendb.php"); //opens connection to database
include("./config/functions.php"); //imports external functions
include("./html_include_1.php"); //open html tags
echo "<title>St. Joseph Red Cross - Home</title>"; //print page title
include("./html_include_2.php"); //rest of html header information
 
//Count the number of rows in important database tables
$org_r = mysql_query("SELECT * FROM organization");
$org_n = mysql_num_rows($org_r);
$per_r = mysql_query("SELECT * FROM person");
$per_n = mysql_num_rows($per_r);
$res_r = mysql_query("SELECT * FROM detailed_resource");
$res_n = mysql_num_rows($res_r);

//Print main tage title and display number of organizations, people and resources in database
print "<center>";
print "<h1 style='display: inline'>St. Joseph Red Cross - Disaster Response Database</h1><br/>";
print "<h3>Managing ".$org_n." organizations, ".$per_n." people, and ".$res_n." resources.</h3>";
print "</center>";
?>
<hr />
<!-- Give a brief explaination of the database -->
Welcome to the St. Joseph County Red Cross Disaster Database.  This online database contains 
contact information for people and organizations who offer aid resources in disaster situations.  
To begin using this database, please select one of the options below.<br/><br/>
<?

//if the user can search information, allow them to access search pages
if( !($_SESSION['access_level_id'] == 8) || ($_SESSION['access_level_id'] == 0) || ($_SESSION['access_level_id'] > 10) || ($_SESSION['access_level_id'] < 0)) {
	?>
    <!-- Pint out the search buttons -->
	<h2 style="display: inline">Search the Database</h2><br />
	<form style="display:inline" action="search.php">
		<input type="submit" value="Search by Keyword" />
	</form>
	<form style="display: inline" action="search/allresources.php">
		<input type="submit" value="Browse Resources" />
	</form><br /><br />
    <?
}

//if the user can add information, allow them to access add functions
if( ($_SESSION['access_level_id'] > 3) && ($_SESSION['access_level_id'] < 10)) {
	?>
    <!-- Print out the add buttons -->
	<h2 style="display: inline">Modify Information</h2><br />
	<form style="display: inline" action="addorganization.php">
		<input type="submit" value="Add an Organization" />
	</form>
	<form style="display: inline" action="addresource1.php">
	    <input type="submit" value="Add a Resource" />
	</form>
	<form style="display: inline" action="addperson.php">
	    <input type="submit" value="Add a Person" />
	</form>
	<form style="display: inline" action="modifychapters.php">
		<input type="submit" value="Modify a Chapter" />
	</form>
	<form style="display: inline" action="modifydistricts.php">
		<input type="submit" value="Modify a District" />
	</form>
	<br /><br />
    <?
}

//If the user is an admin, allow them to access user functions
if (($_SESSION['access_level_id']) == "9") { 
?>
	<!-- Print out the user admin buttons -->
	<h2 style="display: inline">User Accounts</h2><br />
	<form style="display: inline" action="./newuser.php">
		<input type="submit" value="Create A User" />
	</form>
	<form style="display: inline" action="./deleteuser.php">
		<input type="submit" value="Delete A User" />
	</form><br />
  <form style="display: inline" action="./modifyuser.php">
    <input type="submit" value="Change User Permissions" />
  </form>
    <?
}
?>

<br /><br />
<h2 style="display: inline">Change User Information</h2><br />
<form style="display: inline" action="./updateuser.php">
		<input type="submit" value="Change My Information" />
</form><br /><br />
<?
//if the user is an admin, allow them to access CSV files
if( $_SESSION['access_level_id'] == 9) {
	?>
    <!-- Print out the CSV access buttons -->
    <h2 style="display: inline">Download Tables to CSV</h2><br />
	<form style="display: inline" action="csv/per_csv.php">
    	<input type="submit" value="People" />
    </form>
    <form style="display: inline" action="csv/org_csv.php">
   	  <input type="submit" value="Organizations" />
    </form>
	<form style="display: inline" action="csv/res_csv.php">
    	<input type="submit" value="Resources" />
    </form>
	<form style="display: inline" action="csv/shelter_csv.php">
    	<input type="submit" value="Shelters Only" />
	</form><br /><br />
    <?
}
?>
<table align="center">
<tr><td>
  <a href="http://disaster.stjoe-redcross.org/Development/help/DeveloperManualv3.pdf">
  <center>User's Manual<br />(click to open, right click to save)</center></a>
</td>
<td>
       <a href="http://validator.w3.org/check?uri=referer">
         <img src="http://www.w3.org/Icons/valid-html401"
        alt="Valid HTML 4.01 Transitional!" height="31" width="88" align="middle" >
    </a>
</td>
<td>
    <a href="http://jigsaw.w3.org/css-validator/check/referer">
        <img style="border:0;width:88px;height:31px"
            src="http://jigsaw.w3.org/css-validator/images/vcss" align="middle"
            alt="Valid CSS!" >
    </a>
</td>
</tr>
</table>

<?php

echo "</div>";
include("./config/closedb.php"); //close database connection
include("html_include_3.php"); //close HTML tags
?>
