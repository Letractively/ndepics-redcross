<?php

//************************************
// Summer 2012: Henry Kim (hkim16@nd.edu)
// 
// createCitizenReport.php - This is used to provide a web-interface for insertCitizenReport.php
//************************************

include("./config/check_login.php");
include("./config/functions.php");
include("./config/open_database.php");
include("./config/open_html_tags.php");
include("./config/display_error_message.php");

print "<h2>Create A Citizen Report</h2>";

print "<form action='insertCitizenReport.php' method='post' enctype='multipart/form-data'>";
	print "<table>";
		
		// The username is a part of the report.
		print "<input type='hidden' name='username' value='".$_SESSION['username']."' />";
		
		// The image can be a part of the report.
		print "<tr>";
			print "<td><label for='file'>Image filename:</label></td>";
			print "<td><input type='file' name='image' id='image' /></td>";
		print "</tr>";

		// This specifies that the input is coming from the web-interface and not the app (which only sends a Boolean value).
		print "<input type='hidden' name='image_bool' value='testing'>";
		
		print "<tr>";
			print "<td>Time Taken</td>";
			print "<td><input type='text' name='time_taken'></td>";
		print "</tr>";
		
		print "<tr>";
			print "<td>Electricity?</td>";
			print "<td><input type='checkbox' name='electricity' value='1'></td>";
		print "</tr>";
		print "<tr>";
			print "<td>Damage?</td>";
			print "<td><input type='checkbox' name='damage' value='1'></td>";
		print "</tr>";
		print "<tr>";
			print "<td>Accessible?</td>";
			print "<td><input type='checkbox' name='accessible' value='1'></td>";
		print "</tr>";
		
		
		print "<tr>";
			print "<td>Water (basement)?</td>";
			print "<td><input type='checkbox' name='water_basement' value='1'></td>";
		print "</tr>";
		print "<tr>";
			print "<td>Water (first floor)?</td>";
			print "<td><input type='checkbox' name='water_first_floor' value='1'></td>";
		print "</tr>";
		print "<tr>";
			print "<td>Water (first floor, no basement)?</td>";
			print "<td><input type='checkbox' name='water_first_floor_no_basement' value='1'></td>";
		print "</tr>";
		print "<tr>";
			print "<td>Water (second floor)?</td>"; 
			print "<td><input type='checkbox' name='water_second_floor' value='1'></td>";
		print "</tr>";
		
		print "<tr>";
			print "<td>Water Line Broken?</td>";
			print "<td><input type='checkbox' name='water_line_broken' value='1'></td>";
		print "</tr>";
		print "<tr>";
			print "<td>Gas Line Broken?</td>";
			print "<td><input type='checkbox' name='gas_line_broken' value='1'></td>";
		print "</tr>";
		print "<tr>";
			print "<td>Electric Line Broken?</td>";
			print "<td><input type='checkbox' name='electricity_line_broken' value='1'></td>";
		print "</tr>";
		
		print "<tr>";
			print "<td>Name</td>";
			print "<td><input type='text' name='name'></td>";
		print "</tr>";
		print "<tr>";
			print "<td>Street</td>";
			print "<td><input type='text' name='street'></td>";
		print "</tr>";
		print "<tr>";
			print "<td>City</td>";
			print "<td><input type='text' name='city'></td>";
		print "</tr>";
		print "<tr>";
			print "<td>County</td>";
			print "<td><input type='text' name='county'></td>";
		print "</tr>";
		print "<tr>";
			print "<td>State/Province</td>";
			print "<td><input type='text' name='state_province'></td>";
		print "</tr>";
		
		print "<tr>";
			print "<td>Zip Code</td>";
			print "<td><input type='number' name='zip_code' onKeyPress='return numbersOnly(event)'></td>";
		print "</tr>";
		print "<tr>";
			print "<td>Latitude</td>";
			print "<td><input type='number' name='latitude' onKeyPress='return numbersOnly(event)'></td>";
		print "</tr>";
		print "<tr>";
			print "<td>Longitude</td>";
			print "<td><input type='number' name='longitude' onKeyPress='return numbersOnly(event)'></td>";
		print "</tr>";
		
		print "<tr>";
			print "<td><input type='submit' value='Create a Citizen Report'></td>";
		print "</tr>";
	print "</table>";
print "</form>";

include("./config/close_html_tags.php");
include("./config/close_database.php");

?>