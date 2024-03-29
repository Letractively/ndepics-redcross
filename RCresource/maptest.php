<!DOCTYPE html> 
<html> 
<head> 
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" /> 
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/> 
<style type="text/css"> 
  html { height: 100% }
  body { height: 100%; margin: 0px; padding: 0px }
  #map_canvas { height:600px;width:600px }
</style> 
<title>Google Maps JavaScript API v3 Example: Map Simple</title> 
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> 
<script type="text/javascript"> 
  function initialize() {
    var myLatlng = new google.maps.LatLng(-34.397, 150.644);
    var myOptions = {
      zoom: 8,
      center: myLatlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
  }
</script> 
</head> 
<body onload="initialize()">
<div><h2>Hello World</h2>
</div> 
  <div id="map_canvas" align="center"></div> 
</body> 
</html>