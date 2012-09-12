<?php

//************************************
// Summer 2012: Henry Kim (hkim16@nd.edu)
// 
// searchCitizenReport.php - This searches for relevant data from the rc_citizen_reports table.
//************************************

include("./config/check_login.php");
if($_SESSION["authority"] != "admin"){
	header( 'Location: ./home.php' );
}
include("./config/functions.php");
include("./config/open_database.php");
include("./config/open_html_tags.php");

print "<h2>Search Citizens' Report</h2>";

print "<div id='centerText'>";
	print "<form action='tableCitizenReport.php' method='get'><br />";
		print "General Search: <input type='text' name='searchGeneral' /> <br /><br />";
		print "Username Search: <input type='text' name='searchUsername' /> <br /><br />";
		print "Name Search: <input type='text' name='searchName' /> <br /><br />";
		print "Street Search: <input type='text' name='searchStreet' /> <br /><br />";
		print "City Search:<input type='text' name='searchCity' /><br /><br />";
		print "County Search:<input type='text' name='searchCounty' /><br /><br />";
		print "State/Province Search:<input type='text' name='searchStateProvince' /><br /><br />";
		print "Zip Code Search:<input type='number' name='searchZipCode' onKeyPress='return numbersOnly(event)'/><br /><br />";
		// For search, please ensure that sortTerm and sortOrder are the last two search terms (and thus the web address, because this form uses PHP GET method) to ensure proper sorting by functions.js.
		print "<input type='hidden' name='sortTerm' value ='entry_id'>";
		print "<input type='hidden' name='sortOrder' value ='ASC'>";
		print "<input type='reset' value='Clear' />";
		print "<input type='submit' value='Search'/>";
	print "</form>";
print "</div>";

include("./config/close_html_tags.php");
include("./config/close_database.php");

?>