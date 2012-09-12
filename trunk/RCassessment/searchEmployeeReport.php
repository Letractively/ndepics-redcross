<?php

//************************************
// Summer 2012: Henry Kim (hkim16@nd.edu)
// 
// searchEmployeeReport.php - This searches for relevant data from the rc_employee_reports table.
//************************************

include("./config/check_login.php");
if($_SESSION["authority"] != "admin"){
	header( 'Location: ./home.php' );
}
include("./config/functions.php");
include("./config/open_database.php");
include("./config/open_html_tags.php");

print "<h2>Search Employees' Report</h2>";

print "<div id='centerText'>";
	print "<form action='tableEmployeeReport.php' method='get'><br />";
		print "General Search: <input type='text' name='searchGeneral' /> <br /><br />";
		print "DR # Search: <input type='number' name='searchDRNumber' onKeyPress='return numbersOnly(event)'/> <br /><br />";
		print "DR Name Search: <input type='text' name='searchDRName' /> <br /><br />";
		print "State Search:<input type='text' name='searchState' maxlength='2'/><br /><br />";
		print "County Search:<input type='text' name='searchCounty' /><br /><br />";
		print "City/Community Search:<input type='text' name='searchCity' /><br /><br />";
				
		print "Street Search: <input type='text' name='searchStreetName' /> <br /><br />";
		print "House # Search: <input type='text' name='searchHouseNumber' /> <br /><br />";
		print "Apt./Unit # Search: <input type='text' name='searchApartmentNumber' /> <br /><br />";
		print "Damage Classification:";
			print "<select name='searchDamageClassification' />";
				print "<option></option>";
				print "<option>Destroyed</option>";
				print "<option>Major</option>";
				print "<option>Minor</option>";
				print "<option>Affected</option>";
				print "<option>Inaccessible</option>";
			print "</select>";
		print "<br /><br />";
		
		print "Dwelling Type:";
			print "<select name='searchDwellingType' />";
				print "<option></option>";
				print "<option value='S'>Single Family Dwelling</option>";
				print "<option value='M'>Mobile Home</option>";
				print "<option value='A'>Apartment</option>";
			print "</select>";
		print "<br /><br />";
		print "Occupancy Type:";
			print "<select name='searchOccupancyType' />";
				print "<option></option>";
				print "<option value='O'>Owner occupied</option>";
				print "<option value='R'>Renter occupied</option>";
				print "<option value='S'>Seasonal</option>";
			print "</select>";
		print "<br /><br />";
		print "Resident Name: <input type='text' name='searchResidentName' /> <br /><br />";
		print "Username Search: <input type='text' name='searchUsername' /> <br /><br />";
		
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