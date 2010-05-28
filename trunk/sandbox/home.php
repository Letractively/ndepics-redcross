<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2008 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// home.php - Homepage
//****************************
session_start();
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
 }
 include("config/functions.php");
 include("html_include_1.php");
 echo "<title>St. Joseph Red Cross - Disaster Database</title>";
 include("html_include_2.php");
?>
<h1 style="display: inline">St. Joseph Red Cross - Disaster Database</h1><br/>
Welcome to the St. Joseph County Red Cross Disaster Database.  This online database contains 
contact information for people and organizations who offer aid resources in disaster situations.  
To begin using this database, please select one of the options below.<br/><br/>
<?

//if the user can search information
if( !($_SESSION['access_level_id'] == 8) || ($_SESSION['access_level_id'] == 0) || ($_SESSION['access_level_id'] > 10) || ($_SESSION['access_level_id'] < 0))
{
print "<h2 style=\"display: inline\">Search the Database</h2><br/>";
print "<form action=\"search.php\" style=\"display: inline\">";
print "    <input type=\"submit\" value=\"Search by Keyword\">";
print "</form>";
print "<form action=\"search/allresources.php\"  style=\"display: inline\">";
print "    <input type=\"submit\" value=\"Browse all Data\">";
print "</form><br/><br/>";
}

//if the user can add information 
if( ($_SESSION['access_level_id'] > 3) && ($_SESSION['access_level_id'] < 10))
{
	print "<h2 style=\"display: inline\">Add Information</h2><br/>";
	print "	    <form style=\"display: inline\" action=\"addorganization.php\" >";
	print "	    <input type=\"submit\" value=\"Add an Organization\">";
	print "	    </form>";

	print "	    <form style=\"display: inline\" action=\"addresource1.php\">";
	print "	    <input type=\"submit\" value=\"Add a Resource\">";
	print "	    </form>";

	print "	    <form style=\"display: inline\" action=\"addperson.php\" >";
	print "	    <input type=\"submit\" value=\"Add a Person\">";
	print "	    </form>";

	print "<br/><br/>";
}

if (($_SESSION['access_level_id']) == "9") { 

	print "<h2 style=\"display: inline\">User Accounts</h2><br/>\n";
	print	"  <form style=\"display: inline\" action=\"./newuser.php\">\n";
	print	"  <input type=\"submit\" value=\"Create A User\">\n";
	print	"  </form>\n";

	print	"  <form style=\"display: inline\" action=\"./deleteuser.php\">\n";
	print	"  <input type=\"submit\" value=\"Delete A User\">\n";
	print	"  </form><br/>\n";

	print	"  <form style=\"display: inline\" action=\"./modifyuser.php\">\n";
	print	"  <input type=\"submit\" value=\"Change User Permissions\">\n";
	print	"  </form>\n";

	echo "<form style=\"display: inline\" action=\"./updateuser.php\">
	<input type=\"submit\" value=\"Change My Information\">
	</form><br/><br/>\n";
}

//if the user is an admin, allow them to access CSV files
if( $_SESSION['access_level_id'] == 9) {
	print "<h2 style=\"display: inline\">Download Tables to CSV</h2><br/>";
	print "	    <form style=\"display: inline\" action=\"csv/per_csv.php\" >";
	print "	    <input type=\"submit\" value=\"People\">";
	print "	    </form>";

	print "	    <form style=\"display: inline\" action=\"csv/org_csv.php\">";
	print "	    <input type=\"submit\" value=\"Organizations\">";
	print "	    </form>";

	print "	    <form style=\"display: inline\" action=\"csv/res_csv.php\" >";
	print "	    <input type=\"submit\" value=\"Resources\">";
	print "	    </form>";

	print "<br/><br/>";
} 

echo "</div>";
include("html_include_3.php");
?>