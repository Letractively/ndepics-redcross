<?php

//************************************
// Summer 2011: Daniel Bolivar (dbolivar@nd.edu)
// Summer 2012: Henry Kim (hkim16@nd.edu)
// 
// tableCitizenReport.php - This uses PHP to retrieve and display relevant data from the rc_citizen_reports table.
//************************************

include("./config/check_login.php");
if($_SESSION["authority"] != "admin"){
	header( 'Location: ./home.php' );
}
include("./config/functions.php");
include("./config/open_database.php");
include("./config/open_html_tags.php");

print "<h2>Citizen Report Table</h2>";
print "<div id='greeting'>";
  print "<div id='table' class='table'>";
  	print "<table>";
  		// These values are obtained from searchCitizenReport.php.
  		$sortTerm = $_GET['sortTerm'];
  		$sortOrder = $_GET['sortOrder'];
  		
		print "<tr>";
			// This stores the description of the report categories in an array.
			$tableHead = array("Username", "Image", "Time Taken", "Electricity?", "Damage?", "Accessible?", "Water (basement)?", "Water (first floor)?", "Water (first floor, no basement)?", "Water (second floor)?",
								"Water Line Broken?", "Gas Line Broken?", "Electric Line Broken?", "Name", "Street", "City", "County", "State/Province", "Zip Code", "Latitude", "Longitude", "Time Received");
			// This stores the variables of the report categories in an array.
			$tableHeadVar = array("username", "entry_id", "time_taken", "electricity", "damage", "accessible", "water_basement", "water_first_floor", "water_first_floor_no_basement", "water_second_floor", 
								"water_line_broken", "gas_line_broken", "electricity_line_broken", "name", "street", "city", "county", "state_province", "zip_code", "latitude", "longitude", "time_received");
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
		
		// These are the search parameters from searchCitizenReport.php
		$searchGeneral = $_GET["searchGeneral"];
		$searchUsername = $_GET["searchUsername"];
		$searchName = $_GET["searchName"];
		$searchStreet = $_GET["searchStreet"];
		$searchCity = $_GET["searchCity"];
		$searchCounty = $_GET["searchCounty"];
		$searchStateProvince = $_GET["searchStateProvince"];
		$searchZipCode = $_GET["searchZipCode"];
		
		// This is an array of entry_id of reports to show in mapCitizenReport.php
		$selectedEntries = array();
		
		
		// This examines all the reports in the database.
		$query = mysql_query("SELECT * FROM rc_citizen_reports ORDER BY $sortTerm $sortOrder") or die("Error: Viewing Citizen Reports");

		while($fields = mysql_fetch_array($query)){
			
			$username = $fields["username"];
			$entry_id = $fields["entry_id"];
			$image_bool = $fields["image_bool"];
			if($image_bool){
				$image_file_name = $fields["image_file_name"];
				$image_file_name = (string)$image_file_name;
				$time_taken = $fields["time_taken"];
			}
			$electricity = $fields["electricity"];
			$damage = $fields["damage"];
			$accessible = $fields["accessible"];

			$water_basement = $fields["water_basement"];
			$water_first_floor = $fields["water_first_floor"];
			$water_first_floor_no_basement = $fields["water_first_floor_no_basement"];
			$water_second_floor = $fields["water_second_floor"];

			$water_line_broken = $fields["water_line_broken"];
			$gas_line_broken = $fields["gas_line_broken"];
			$electricity_line_broken = $fields["electricity_line_broken"];

			$name = $fields["name"];
			$street = $fields["street"];
			$city = $fields["city"];
			$county = $fields["county"];
			$state_province = $fields["state_province"];
			$zip_code = $fields["zip_code"];
			
			$latitude = $fields["latitude"];
			$longitude = $fields["longitude"];
			$time_received = $fields["time_received"];
			
			// This compares all entries against the searchCitizenReport.php values using sub-string matches.
			$approved_display = false;
			if( 
				(stripos($name, $searchGeneral) !== false || stripos($street, $searchGeneral) !== false || stripos($city, $searchGeneral) !== false || stripos($county, $searchGeneral) !== false ||
							stripos($state_province, $searchGeneral) !== false || stripos($zip_code, $searchGeneral) !== false || strcasecmp("", $searchGeneral) == 0) &&
				( stripos($username, $searchUsername) !== false || strcasecmp("", $searchUsername) == 0) &&
				( stripos($name, $searchName) !== false || strcasecmp("", $searchName) == 0) &&
				( stripos($street, $searchStreet) !== false || strcasecmp("", $searchStreet) == 0) &&
				( stripos($city, $searchCity) !== false || strcasecmp("", $searchCity) == 0) &&
				( stripos($county, $searchCounty) !== false || strcasecmp("", $searchCounty) == 0) &&
				( stripos($state_province, $searchStateProvince) !== false || strcasecmp("",$searchStateProvince) == 0) &&
				( stripos($zip_code, $searchZipCode) !== false || strcasecmp("",$searchZipCode) == 0)
			){
				$approved_display = true;
			}
			
			// If accepted by the search parameters then display the report.
			if($approved_display){
				print "<tr onmouseover='this.style.backgroundColor=\"yellow\";' onmouseout='this.style.backgroundColor=\"d4e3e5\";'>";
					print "<td>".$username."</td>";
					if($image_bool){
						print "<td>";
							print "<a href='citizen_images/".$image_file_name."'>";
								print "<img src='citizen_images/".$image_file_name."'height='40' width='60' />";
							print "</a>";
						print "</td>";
						print "<td>".$time_taken."</td>";
					}
					else{
						print "<td>No Picture</td>";
						print "<td></td>";
					}
					print "<td>".$electricity."</td>";
					print "<td>".$damage."</td>";
					print "<td>".$accessible."</td>";
			
					print "<td>".$water_basement."</td>";
					print "<td>".$water_first_floor."</td>";
					print "<td>".$water_first_floor_no_basement."</td>";
					print "<td>".$water_second_floor."</td>";
			
					print "<td>".$water_line_broken."</td>";
					print "<td>".$gas_line_broken."</td>";
					print "<td>".$electricity_line_broken."</td>";
			
					print "<td>".$name."</td>";
					print "<td>".$street."</td>";
					print "<td>".$city."</td>";
					print "<td>".$county."</td>";
					print "<td>".$state_province."</td>";
					print "<td>".$zip_code."</td>";
					print "<td>".$latitude."</td>";
					print "<td>".$longitude."</td>";
					print "<td>".$time_received."</td>";
					print "<td>";
						print "<form action='deleteCitizenReport.php' method='post'>";
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
			print "<form action='downloadCitizenReport.php' method='post'>";
				print "<input type='hidden' name='serial' value='$serial'>";
				print "<input type='submit' value='Download the table'>";
			print "</form>";
			
			print "<form action='downloadCitizenImage.php' method='post'>";
				print "<input type='hidden' name='serial' value='$serial'>";
				print "<input type='submit' value='Download the images'>";
			print "</form>";
			
			print "<form action='mapCitizenReport.php' method='post'>";
				print "<input type='hidden' name='serial' value='$serial'>";
				print "<input type='submit' value='Map the table'>";
			print "</form>";
		print "</div>";
		
	print "</div>";
print "</div>";

include("./config/close_html_tags.php");
include("./config/close_database.php");

?> 