<?php

//************************************
// Summer 2012: Henry Kim (hkim16@nd.edu)
// 
// createEmployeeReport.php - This is used to provide a web-interface for insertEmployeeReport.php
//************************************

include("./config/check_login.php");
// This is an employee feature, thus check if the current user is an admin.
if($_SESSION["authority"] != "admin"){
	header( 'Location: ./home.php' );
}
include("./config/functions.php");
include("./config/open_database.php");
include("./config/open_html_tags.php");
include("./config/display_error_message.php");

print "<h2>Create An Employee Report</h2>";

print "<form action='insertEmployeeReport.php' method='post' enctype='multipart/form-data'>";
	print "<table>";

		print "<tr>";
			print "<td>DR #</td>";
			print "<td><input type='number' name='dr_number' onKeyPress='return numbersOnly(event)'></td>";
		print "</tr>";
		print "<tr>";
			print "<td>DR Name</td>";
			print "<td><input type='text' name='dr_name'></td>";
		print "</tr>";
		
		print "<tr>";
			print "<td>State</td>";
			print "<td><input type='text' name='state' maxlength='2'></td>";
		print "</tr>";
		print "<tr>";
			print "<td>County</td>";
			print "<td><input type='text' name='county'></td>";
		print "</tr>";
		print "<tr>";
			print "<td>City/Community</td>";
			print "<td><input type='text' name='city'></td>";
		print "</tr>";
		print "<tr>";
			print "<td>Report Time</td>";
			print "<td><input type='text' name='report_time'></td>";
		print "</tr>";
		
		print "<tr>";
			print "<td>Street Name</td>";
			print "<td><input type='text' name='street_name'></td>";
		print "</tr>";
		print "<tr>";
			print "<td>Geographic Reference</td>";
			print "<td><input type='text' name='geo_ref'></td>";
		print "</tr>";
		
		print "<tr>";
			print "<td>House #</td>";
			print "<td><input type='text' name='house_number'></td>";
		print "</tr>";
		print "<tr>";
			print "<td>Apt./Unit #</td>";
			print "<td><input type='text' name='apartment_number'></td>";
		print "</tr>";
		print "<tr>";
			print "<td>Damage Classification</td>";
			print "<td>";
				print "<select name='damage_classification'>";
					print "<option>Destroyed</option>";
					print "<option>Major</option>";
					print "<option>Minor</option>";
					print "<option>Affected</option>";
					print "<option>Inaccessible</option>";
				print "</select>";
			print "</td>";
		print "</tr>";
		print "<tr>";
			print "<td>Dwelling Type</td>";
			print "<td>";
				print "<select name='dwelling_type'>";
					print "<option value='S'>Single Family Dwelling</option>";
					print "<option value='M'>Mobile Home</option>";
					print "<option value='A'>Apartment</option>";
				print "</select>";
			print "</td>";
		print "</tr>";

		print "<tr>";
			print "<td># of Floors in dwelling or unit?</td>";
			print "<td><input type='number' name='floor_count' onKeyPress='return numbersOnly(event)'></td>";
		print "</tr>";
		
		print "<tr>";
			print "<td>Is there a basement?</td>";
			print "<td><input type='checkbox' name='basement_bool' value='1'></td>";
		print "</tr>";
		
		print "<tr>";
			print "<td>Water level in living area (inches)</td>";
			print "<td><input type='number' name='water_living_area_inches' onKeyPress='return numbersOnly(event)'></td>";
		print "</tr>";
		print "<tr>";
			print "<td>Water level in basement (inches)</td>";
			print "<td><input type='number' name='water_basement_inches' onKeyPress='return numbersOnly(event)'></td>";
		print "</tr>";
		
		print "<tr>";
			print "<td>Is the electricity on?</td>";
			print "<td><input type='checkbox' name='electricity_bool' value='1'></td>";
		print "</tr>";
		print "<tr>";
			print "<td>Occupancy Type</td>";
			print "<td>";
				print "<select name='occupancy_type'>";
					print "<option value='O'>Owner occupied</option>";
					print "<option value='R'>Renter occupied</option>";
					print "<option value='S'>Seasonal</option>";
				print "</select>";
			print "</td>";
		print "</tr>";
		
		print "<tr>";
			print "<td>OR/901</td>";
			print "<td><input type='text' name='or_901'></td>";
		print "</tr>";
		print "<tr>";
			print "<td>Description</td>";
			print "<td><input type='text' name='description'></td>";
		print "</tr>";
		
		print "<tr>";
			print "<td>Name (Resident)</td>";
			print "<td><input type='text' name='resident_name'></td>";
		print "</tr>";
		


		// This specifies that the input is coming from the web-interface and not the app (which only sends a Boolean value).
		print "<input type='hidden' name='image_bool' value='testing'>";
		// The image can be a part of the report.
		print "<tr>";
			print "<td><label for='file'>Image filename:</label></td>";
			print "<td><input type='file' name='image' id='image' /></td>";
		print "</tr>";
		
		print "<tr>";
			print "<td>Latitude</td>";
			print "<td><input type='number' name='latitude' onKeyPress='return numbersOnly(event)'></td>";
		print "</tr>";
		print "<tr>";
			print "<td>Longitude</td>";
			print "<td><input type='number' name='longitude' onKeyPress='return numbersOnly(event)'></td>";
		print "</tr>";
		
		// The username is a part of the report.
		print "<input type='hidden' name='username' value='".$_SESSION['username']."' />";
		
		print "<tr>";
			print "<td><input type='submit' value='Create an Employee Report'></td>";
		print "</tr>";
	print "</table>";
print "</form>";

include("./config/close_html_tags.php");
include("./config/close_database.php");

?>