<?php

//************************************
// Summer 2012: Henry Kim (hkim16@nd.edu)
// 
// home.php - This is the home page of the website accessible after logging-in.
//************************************

include("./config/check_login.php");
include("./config/functions.php");
include("./config/open_database.php");
include("./config/open_html_tags.php");

print "<h2>Home</h2>";
  
print "<div id='centerText'>";

	// This is used ensure that the message is re-set upon being re-directed here.
	$_SESSION["message"] = "";
	
	// This is a counter of the number of citizen and employee reports in the database.
	if($_SESSION["authority"] == "admin"){
		$query1 = "SELECT * FROM rc_citizen_reports"; 
		$query2 = "SELECT * FROM rc_employee_reports";
		$result1 = mysql_query($query1) or die(mysql_error()); 
		$result2 = mysql_query($query2) or die(mysql_error());
		$count1 = mysql_num_rows($result1);
		$count2 = mysql_num_rows($result2);
		print "There are ".$count1." citizen reports and ".$count2." employee reports.";
	}
	
	print "<table>";
		print "<tr>";
			print "<td>Account Tools</td>";
		print "</tr>";
		print "<tr>";
			print "<td><input type='button' value='Change Profile Information' onClick=' window.location.href = \"./changeProfile.php\" '></td>";
			print "<td><input type='button' value='Change Password' onClick=' window.location.href = \"./changePassword.php\" '></td>";
			print "<td><input type='button' value='Report A Problem' onClick=' window.location.href = \"./reportProblem.php\" '></td>";
		print "</tr>";
	print "</table>";	
	
	if($_SESSION["authority"] == "admin"){
		print "<table>";
			print "<tr>";
				print "<td>Admin Tools</td>";
			print "</tr>";
			print "<tr>";
				print "<td><input type='button' value='Create A User' onClick=' window.location.href = \"./createUser.php\" '></td>";
				print "<td><input type='button' value='Change A User' onClick=' window.location.href = \"./changeUser.php\" '></td>";
				print "<td><input type='button' value='Delete A User' onClick=' window.location.href = \"./deleteUser.php\" '></td>";
			print "</tr>";
		print "</table>";
	}
	
	print "<table>";
		print "<tr>";
			print "<td>Citizen Features</td>";
		print "</tr>";
		print "<tr>";
			print "<td><input type='button' value='Create A Citizen Report' onClick='window.location.href=\"./createCitizenReport.php\" '></td>";
			if($_SESSION["authority"] == "admin"){	
				print "<td><input type='button' value='Search Citizen Reports' onClick=' window.location.href = \"./searchCitizenReport.php\" '></td>";
				print "<td><input type='button' value='Display Citizen Reports' onClick=' window.location.href = \"./tableCitizenReport.php?searchGeneral=&searchUsername=&searchName=&searchStreet=&searchCity=&searchCounty=&searchStateProvince=&searchZipCode=&sortTerm=entry_id&sortOrder=ASC\" '></td>";
				print "<td><input type='button' value='Download Citizen Reports' onClick='window.location.href = \"./downloadCitizenReport.php\" '></td>";
				print "<td><input type='button' value='Download Citizen Images' onClick='window.location.href = \"./downloadCitizenImage.php\" '></td>";	
			}
		print "</tr>";
	print "</table>";
		
	if($_SESSION["authority"] == "admin"){
		print "<table>";
			print "<tr>";
				print "<td>Employee Features</td>";
			print "</tr>";
			print "<tr>";
				print "<td><input type='button' value='Create An Employee Report' onClick=' window.location.href = \"./createEmployeeReport.php\" '></td>";		
				print "<td><input type='button' value='Search Employee Reports' onClick=' window.location.href = \"./searchEmployeeReport.php\" '></td>";
				print "<td><input type='button' value='Display Employee Reports' onClick=' window.location.href = \"./tableEmployeeReport.php?searchGeneral=&searchDRNumber=&searchDRName=&searchState=&searchCounty=&searchCity=&searchStreetName=&searchHouseNumber=&searchApartmentNumber=&searchDamageClassification=&searchDwellingType=&searchOccupancyType=&searchResidentName=&searchUsername=&sortTerm=entry_id&sortOrder=ASC\" '></td>";
				print "<td><input type='button' value='Download Employee Reports' onClick='window.location.href = \"./downloadEmployeeReport.php\" '></td>";
				print "<td><input type='button' value='Download Employee Images' onClick='window.location.href = \"./downloadEmployeeImage.php\" '></td>";
			print "</tr>";
		print "</table>";
	}
print "</div>";

include("./config/close_html_tags.php");
include("./config/close_database.php");

?>