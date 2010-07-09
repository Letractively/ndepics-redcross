<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Summer 2010 - Matt Mooney
// mapping.php - generate interactive map for organization info
// This page uses Google Maps JavaScript API V3. See http://code.google.com/apis/maps/documentation/javascript/
//****************************
$addr = $_GET['a']; //GET address from URL
?>
<!DOCTYPE html> <!-- This is an HTML5 document -->
<html> 
<head> 
<style type="text/css">
  html { height: 100% }
  body { height: 100%; margin: 0px; padding: 0px }
  #map_canvas { height: 100% }
</style>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no"/> 
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/> 
<title>Google Maps JavaScript API</title> 
<link href="standard.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> 
<script type="text/javascript"> 
  var geocoder;
  var map;
  var latlng;
  var address;

function codeAddress() {
	geocoder = new google.maps.Geocoder();
	latlng = new google.maps.LatLng(0, 0);
	var myOptions = {
      zoom: 15,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
	
	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	var address = document.getElementById("address").value;
	
    if (geocoder) {
      geocoder.geocode( { 'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          map.setCenter(results[0].geometry.location);
          var marker = new google.maps.Marker({
              map: map, 
              position: results[0].geometry.location
          });
        } else {
          alert("INFO: The Google map did not load correctly. Geocoding the provided address was not successful for the following reason: " + status);
        }
      });
    }
  }
</script> 
</head> 
<body onLoad="codeAddress()"> 
<input id="address" type="hidden" value="<? echo $addr; ?>"> <!-- Store address in hidden input -->
<div id="map_canvas" style="height:100%;width:100%;"></div> <!-- Fill entire page with map because it is accessed as a frame -->
</body> 
</html>