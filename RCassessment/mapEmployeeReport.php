<?php

//************************************
// Summer 2012: Henry Kim (hkim16@nd.edu)
// 
// mapEmployeeReport.php - This uses Google Maps API v3 to display information in the employee table.
//************************************

include("./config/check_login.php");
include("./config/functions.php");
include("./config/open_database.php");
include("./config/open_html_tags.php");
include("./config/display_error_message.php");

?>

<script type="text/javascript">

	// This obtains the information about each entry from tableEmployeeReport.php
	<?php
		// This obtains the serialized string and unserializes it into an array.
		$serial = $_POST["serial"];
		$mapTheseEntries = unserialize(stripslashes($serial));
		$mapTotalPHP = count($mapTheseEntries);

		// These are the array of relevant values to create a Google map marker and/or on a Google map window.
		$drnamesPHP = array();
		$drnumberPHP = array();
		$houseNumberPHP = array();
		$streetNamePHP = array();
		$apartmentNumberPHP = array();
		$cityPHP = array();
		$statePHP = array();
		
		$latitudesPHP = array();
		$longitudesPHP = array();
		$imageFileNamesPHP = array();
		
		// This goes through all the entries being mapped and creates PHP array.
		for($i=0; $i < $mapTotalPHP; $i++){
			$query = "SELECT * FROM rc_employee_reports WHERE entry_id = '$mapTheseEntries[$i]' ";
			$result = mysql_query($query) or die(mysql_error());
			$report = mysql_fetch_array($result);
			array_push($drnamesPHP, $report['dr_name']);
			array_push($drnumberPHP, $report['dr_number']);
			array_push($houseNumberPHP, $report['house_number']);
			array_push($streetNamePHP, $report['street_name']);
			array_push($apartmentNumberPHP, $report['apartment_number']);
			array_push($cityPHP, $report['city']);
			array_push($statePHP, $report['state']);
			array_push($latitudesPHP, $report['latitude']);
			array_push($longitudesPHP, $report['longitude']);
			array_push($imageFileNamesPHP, $report['image_file_name']);
		}
		
		// This converts the PHP variables into a JSON variables.
		$mapTotalJSON = json_encode($mapTotalPHP);
		$drnamesJSON = json_encode($drnamesPHP);
		$drnumberJSON = json_encode($drnumberPHP);
		$houseNumberJSON = json_encode($houseNumberPHP);
		$streetNameJSON = json_encode($streetNamePHP);
		$apartmentNumberJSON = json_encode($apartmentNumberPHP);
		$cityJSON = json_encode($cityPHP);
		$stateJSON = json_encode($statePHP);
		$latitudesJSON = json_encode($latitudesPHP);
		$longitudesJSON = json_encode($longitudesPHP);
		$imageFileNamesJSON = json_encode($imageFileNamesPHP);
		
		// This converts a JSON variables into a Javascript variables.
		echo "var mapTotal = ".$mapTotalJSON.";\n";
		echo "var drnames = ".$drnamesJSON.";\n";
		echo "var drnumber = ".$drnumberJSON.";\n";
		echo "var houseNumber = ".$houseNumberJSON.";\n";
		echo "var streetName = ".$streetNameJSON.";\n";
		echo "var apartmentNumber = ".$apartmentNumberJSON.";\n";
		echo "var city = ".$cityJSON.";\n";
		echo "var state = ".$stateJSON.";\n";
		echo "var latitudes = ".$latitudesJSON.";\n";
		echo "var longitudes = ".$longitudesJSON.";\n";
		echo "var imageFileNames = ".$imageFileNamesJSON.";\n";
	?>
	
	function initialize() {
		// The default location, zoom level and map type is determined.
		var myOptions = {
			center: new google.maps.LatLng(41.702589, -86.237097),
			zoom: 8,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
		
		// This is the Google Maps infowindow.
		var contentString = "This is the default content string.";
		var infowindow = new google.maps.InfoWindow({
			content: contentString
		});
		
		// This is used to create a contentString (for the infobox) and markers for each report.
		var contentStrings = new Array();
		var markers = new Array();
		
		// This creates a marker and contentString of the infobox for each report.
		for(var i=0; i < mapTotal; i++){
			contentStrings[i] = drnames[i] + "<br />" + "DR Number: " + drnumber[i] + "<br />" + houseNumber[i] + " " + streetName[i] + " " + apartmentNumber[i] +  "<br />" + city[i] + ", " + state[i];
			markers[i] = new google.maps.Marker({
				position: new google.maps.LatLng(latitudes[i],longitudes[i]), 
				map: map,
				// convert the int to string.
				title:i+""
			});
		}
		// This shows the infowindow with unique information depending on the marker being pressed.
		for(var j=0, currMarker; currMarker = markers[j]; j++){
				google.maps.event.addListener(currMarker, 'click', function(e){
				// For some reason, the value of the variable j is total number of markers plus one and does not change. 
				// Thus, each marker has an index value to additional information that can be shown in the infowindow.
				
				// convert the string to int.
				currCount = parseInt(this.getTitle());
				if(imageFileNames[currCount] != ""){
					infowindow.setContent("<img height='50' width='50' src='./employee_images/" + imageFileNames[currCount] + "' /><br />" + contentStrings[currCount]);
				}
				else{
					infowindow.setContent(contentStrings[currCount]);
				}
				infowindow.open(map,this);
			});
		}
	}
	
	// This loads the markers and the infoboxes.
	function loadScript(){
		var script = document.createElement("script");
		script.type= "text/javascript";
		script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyDj4PV9-O2RtecEeT7lOPOEhAlcWnu3aAY&sensor=true&callback=initialize"
		document.body.appendChild(script);
	}
		
	window.onload = loadScript;
</script>
	
<div id="map_canvas"></div>
<?php
include("./config/close_html_tags.php");
include("./config/close_database.php");

?>