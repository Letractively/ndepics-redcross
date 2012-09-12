<?php

//************************************
// Summer 2011: Daniel Bolivar (dbolivar@nd.edu)
// Summer 2012: Henry Kim (hkim16@nd.edu)
// 
// tableEmployeeReport.php - This uses PHP to retrieve and display relevant data from the rc_employee_reports table.
//************************************

include("./config/check_login.php");
if($_SESSION["authority"] != "admin"){
	header( 'Location: ./home.php' );
}
include("./config/functions.php");
include("./config/open_database.php");
include("./config/open_html_tags.php");

print "<h2>Employee Report Table</h2>";
print "<div id='greeting'>";
  print "<div id='table' class='table'>";
  	print "<table>";
  		// These values are obtained from searchEmployeeReport.php.
  		$sortTerm = $_GET['sortTerm'];
  		$sortOrder = $_GET['sortOrder'];
  		
		print "<tr>";
			// This stores the description of the report categories in an array.
			$tableHead = array("DR #", "DR Name", "State", "County", "City/Community", "Report Time", "Street Name", "Geographic Reference", "House #", "Apartment #",
								"Damage Classification", "Dwelling Type", "# of Floors in dwelling or unit", "Is there a Basement?", "Water level in living area (inches)", "Water level in basement (inches)", 
								"Is the electricity on?", "Occupancy Type", "OR/901", "Description", "Name", "Image", "Latitude", "Longitude", "Username", "Time Received");
			// This stores the variables of the report categories in an array.
			$tableHeadVar = array("dr_number", "dr_name", "state", "county", "city", "report_time", "street_name", "geo_ref", "house_number", "apartment_number", 
									"damage_classification", "dwelling_type", "floor_count", "basement_bool", "water_living_area_inches", "water_basement_inches",
									"electricity_bool", "occupancy_type", "or_901", "description", "resident_name", "entry_id", "latitude", "longitude", "username", "time_received");
			$tableHeadCount = count($tableHead);
			
			// This prints the table heads. When clicked, the web address is changed with different search parameters.
			for($i=0; $i < $tableHeadCount; $i++){
				if($sortOrder == 'ASC'){			
					print "<th onClick='search(\"".$tableHeadVar[$i]."\", \"ASC\");'>".$tableHead[$i]." ";
					if($sortTerm == $tableHeadVar[$i]){
						print "<img src='./style/arrow_up.png'>";
					}
					print "</th>";
				}
				else{
					print "<th onClick='search(\"".$tableHeadVar[$i]."\", \"DESC\");'>".$tableHead[$i]." ";
					if($sortTerm == $tableHeadVar[$i]){
						print "<img src='./style/arrow_down.png'>";
					}
					print "</th>";
				}
			}
			print "<th>Delete?</th>";
		print "</tr>";
		
		// These are the search parameters from searchEmployeeReport.php
		$searchGeneral = $_GET["searchGeneral"];
		$searchDRNumber = $_GET["searchDRNumber"];
		$searchDRName = $_GET["searchDRName"];
		$searchState = $_GET["searchState"];
		$searchCounty = $_GET["searchCounty"];
		$searchCity = $_GET["searchCity"];
		$searchStreetName = $_GET["searchStreetName"];
		$searchHouseNumber = $_GET["searchHouseNumber"];
		$searchApartmentNumber = $_GET["searchApartmentNumber"];
		$searchDamageClassification = $_GET["searchDamageClassification"];
		$searchDwellingType = $_GET["searchDwellingType"];
		$searchOccupancyType = $_GET["searchOccupancyType"];
		$searchResidentName = $_GET["searchResidentName"];
		$searchUsername = $_GET["searchUsername"];
		
		// This is an array of entry_id of reports to show in mapEmployeeReport.php
		$selectedEntries = array();
		
		// This examines all the reports in the database.
		if($sortTerm == "damage_classification"){
			if($sortOrder == 'DESC'){
				$query = mysql_query("SELECT * FROM rc_employee_reports ORDER BY FIELD(damage_classification, 'Inaccessible', 'Affected', 'Minor', 'Major', 'Destroyed') ") or die("Error: Viewing Employee Reports");
			}
			else{
				$query = mysql_query("SELECT * FROM rc_employee_reports ORDER BY FIELD(damage_classification, 'Destroyed', 'Major', 'Minor', 'Affected', 'Inaccessible') ") or die("Error: Viewing Employee Reports");
			}
		}
		else{
			$query = mysql_query("SELECT * FROM rc_employee_reports ORDER BY $sortTerm $sortOrder") or die("Error: Viewing Employee Reports");
		}
		
		while($fields = mysql_fetch_array($query)){
			
			$entry_id = $fields["entry_id"];

			$dr_number = $fields["dr_number"];
			$dr_name = $fields["dr_name"];

			$state = $fields["state"];
			$county = $fields["county"];
			$city = $fields["city"];
			$report_time = $fields["report_time"];
			
			$street_name = $fields["street_name"];
			$geo_ref = $fields["geo_ref"];
			$house_number = $fields["house_number"];
			$apartment_number = $fields["apartment_number"];
			
			$damage_classification = $fields["damage_classification"];
			$dwelling_type = $fields["dwelling_type"];

			$floor_count = $fields["floor_count"];
			$basement_bool = $fields["basement_bool"];
			$water_living_area_inches = $fields["water_living_area_inches"];
			$water_basement_inches = $fields["water_basement_inches"];
			$electricity_bool = $fields["electricity_bool"];
			$occupancy_type = $fields["occupancy_type"];
			$or_901 = $fields["or_901"];
			$description = $fields["description"];
			
			$resident_name = $fields["resident_name"];
			
			$image_bool = $fields["image_bool"];
			if($image_bool){
				$image_file_name = $fields["image_file_name"];
				$image_file_name = (string)$image_file_name;
			}
			
			$latitude = $fields["latitude"];
			$longitude = $fields["longitude"];
			
			$username = $fields["username"];
			$time_received = $fields["time_received"];
			
			// This compares all entries against the searchEmployeeReport.php values using sub-string matches.
			$approved_display = false;
			if( 
				(stripos($dr_number, $searchGeneral) !== false || stripos($dr_name, $searchGeneral) !== false || 
							stripos($state, $searchGeneral) !== false || stripos($county, $searchGeneral) !== false || stripos($city,$searchGeneral) !== false ||
							stripos($street_name, $searchGeneral) !== false || stripos($house_number, $searchGeneral) !== false || stripos($apartment_number, $searchGeneral) !== false ||
							stripos($damage_classification, $searchGeneral) !== false || stripos($dwelling_type, $searchGeneral) !== false || 
							stripos($occupancy_type, $searchGeneral) !== false || stripos($resident_name, $searchGeneral) !== false || stripos($username, $searchGeneral) !== false ||
							strcasecmp("", $searchGeneral) == 0) &&
				( stripos($dr_number, $searchDRNumber) !== false || strcasecmp("", $searchDRNumber) == 0) &&
				( stripos($dr_name, $searchDRName) !== false || strcasecmp("", $searchDRName) == 0) &&
				( stripos($state, $searchState) !== false || strcasecmp("", $searchState) == 0) &&
				( stripos($county, $searchCounty) !== false || strcasecmp("", $searchCounty) == 0) &&
				( stripos($city, $searchCity) !== false || strcasecmp("", $searchCity) == 0) &&
				( stripos($street_name, $searchStreetName) !== false || strcasecmp("", $searchStreetName) == 0) &&	
				( stripos($house_number, $searchHouseNumber) !== false || strcasecmp("", $searchHouseNumber) == 0) &&	
				( stripos($apartment_number, $searchApartmentNumber) !== false || strcasecmp("", $searchApartmentNumber) == 0) &&	
				( stripos($damage_classification, $searchDamageClassification) !== false || strcasecmp("", $searchDamageClassification) == 0) &&
				( stripos($dwelling_type, $searchDwellingType) !== false || strcasecmp("", $searchDwellingType) == 0) &&
				( stripos($occupancy_type, $searchOccupancyType) !== false || strcasecmp("", $searchOccupancyType) == 0) && 
				( stripos($resident_name, $searchResidentName) !== false || strcasecmp("", $searchResidentName) == 0) &&
				( stripos($username, $searchUsername) !== false || strcasecmp("", $searchUsername) == 0)
			){
				$approved_display = true;
			}
			
			// If accepted by the search parameters then display the report.
			if($approved_display){
					print "<tr onmouseover='this.style.backgroundColor=\"yellow\";' onmouseout='this.style.backgroundColor=\"d4e3e5\";'>";
					
					print "<td>".$dr_number."</td>";
					print "<td>".$dr_name."</td>";
					print "<td>".$state."</td>";
					print "<td>".$county."</td>";
					print "<td>".$city."</td>";
					print "<td>".$report_time."</td>";
					
					print "<td>".$street_name."</td>";
					print "<td>".$geo_ref."</td>";
					print "<td>".$house_number."</td>";
					print "<td>".$apartment_number."</td>";
					
					print "<td>".$damage_classification."</td>";
					print "<td>".$dwelling_type."</td>";
				
					print "<td>".$floor_count."</td>";
					print "<td>".booleanToYesNo($basement_bool)."</td>";
					print "<td>".$water_living_area_inches."</td>";
					print "<td>".$water_basement_inches."</td>";
					print "<td>".booleanToYesNo($electricity_bool)."</td>";
					print "<td>".$occupancy_type."</td>";
					
					print "<td>".$or_901."</td>";
					print "<td>".$description."</td>";
					print "<td>".$resident_name."</td>";
					
					
					if($image_bool){
						print "<td>";
							print "<a href='employee_images/".$image_file_name."'>";
								print "<img src='employee_images/".$image_file_name."'height='40' width='60' />";
							print "</a>";
						print "</td>";
					}
					else{
						print "<td>No Picture</td>";
					}
					
					print "<td>".$latitude."</td>";
					print "<td>".$longitude."</td>";
					
					print "<td>".$username."</td>";
					print "<td>".$time_received."</td>";
					print "<td>";
						print "<form action='deleteEmployeeReport.php' method='post'>";
							print "<input type='hidden' name='entry_id' value='$entry_id'>";
							print "<input type='submit' value='Delete'>";
						print "</form>";
					print "</td>";
					array_push($selectedEntries, $entry_id);
				print "</tr>";
			}
		}
		print "</table>";
		
		// This serializes the selectedEntries array into a string that can be sent to the following PHP scripts.
		$serial = serialize($selectedEntries);
		print "<div id='centerText'>";
			print "<form action='downloadEmployeeReport.php' method='post'>";
				print "<input type='hidden' name='serial' value='$serial'>";
				print "<input type='submit' value='Download the table'>";
			print "</form>";
			
			print "<form action='downloadEmployeeImage.php' method='post'>";
				print "<input type='hidden' name='serial' value='$serial'>";
				print "<input type='submit' value='Download the images'>";
			print "</form>";
			
			print "<form action='mapEmployeeReport.php' method='post'>";
				print "<input type='hidden' name='serial' value='$serial'>";
				print "<input type='submit' value='Map the table'>";
			print "</form>";
		print "</div>";
		
	print "</div>";
print "</div>";
include("./config/close_html_tags.php");
include("./config/close_database.php");

?> 