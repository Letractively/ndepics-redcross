<?php

$street_address = $_POST['street_address'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];
$distance = $_POST['distance'];

session_start();
// Validate the users's session
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
}

include ("./config/dbconfig.php");
include ("./config/opendb.php");
include ("./config/functions.php");

//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: Matt Daye
//  Spring 2012
//****************************

include("./html_include_1.php");
if(($state != NULL || $state != "") || ($zip != NULL || $zip != ""))
{
    $street_address_search = str_replace(" ","+",$street_address);
    $city_search = str_replace(" ","+",$city);

    if($zip == NULL || $zip == "")
    {
        $search_url = 'http://maps.google.com/maps/api/geocode/json?address='.$street_address_search.'+'.$city_search.',+'.$state.'&sensor=false';
    }
    else
    {
        $search_url = 'http://maps.google.com/maps/api/geocode/json?address='.$zip.',&sensor=false';
    }


    $geocode=file_get_contents($search_url);

    $output= json_decode($geocode);

    $lat = $output->results[0]->geometry->location->lat;
    $longitude = $output->results[0]->geometry->location->lng;

    $query = "SELECT *
    FROM organization
    WHERE SQRT( ( 69.1 * ( lat - ".$lat." ) ) * ( 69.1 * ( lat - ".$lat." ) ) + ( 53.0 * ( longitude - ".$longitude." ) ) * ( 53.0 * ( longitude - ".$longitude." ) ) ) < ".$distance."
    ORDER BY SQRT( ( 69.1 * ( lat - ".$lat." ) ) * ( 69.1 * ( lat - ".$lat." ) ) + ( 53.0 * ( longitude - ".$longitude." ) ) * ( 53.0 * ( longitude - ".$longitude." ) ) )  ASC";
    
    $query_shelter = "SELECT *
    FROM resource_listing
    WHERE resource_id = 1";
    
    $query_food = "SELECT *
    FROM resource_listing
    WHERE resource_id = 4";
    
    $query_services = "SELECT *
    FROM resource_listing
    WHERE resource_id = 6";
    
    $query_police = "SELECT *
    FROM resource_listing
    WHERE resource_id = 7";

    $result = mysql_query($query) or die ("Search query did not run correctly. Please try again.");
    $result_food = mysql_query($query_food) or die ("Food query did not run correctly. Please try again.");
    $result_shelter = mysql_query($query_shelter) or die ("Shelter query did not run correctly. Please try again.");
    $result_services = mysql_query($query_services) or die ("Services query did not run correctly. Please try again.");
    $result_police = mysql_query($query_police) or die ("Police query did not run correctly. Please try again.");
    
    while ( $row = mysql_fetch_assoc($result_food) )
    {
      $food[] = $row['organization_id'];
    }
    while ( $row = mysql_fetch_assoc($result_shelter) )
    {
      $shelter[] = $row['organization_id'];
    }
    while ( $row = mysql_fetch_assoc($result_services) )
    {
      $services[] = $row['organization_id'];
    }
    while ( $row = mysql_fetch_assoc($result_police) )
    {
      $police[] = $row['organization_id'];
    }
    
    echo "
    <meta name=\"viewport\" content=\"initial-scale=1.0, user-scalable=no\" />
    <meta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\"/>
    <link href=\"http://code.google.com/apis/maps/documentation/javascript/examples/default.css\" rel=\"stylesheet\" type=\"text/css\" />
    <script type=\"text/javascript\" src=\"//maps.googleapis.com/maps/api/js?sensor=false\"></script>
    <script type=\"text/javascript\">
function initialize() {
  var map_center = new google.maps.LatLng(".$lat.",".$longitude.");
  var myOptions = {
    zoom: 12,
    center: map_center,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };

  var map = new google.maps.Map(document.getElementById(\"map_canvas\"), myOptions);
";

  // Begin plotting points
  echo "
  var latlng1 = [
    new google.maps.LatLng(".$lat.",".$longitude."),
";
      $iter = 0;
      while ( $row = mysql_fetch_assoc($result) ) {
        
      $info[$iter] = $row;
      echo "    new google.maps.LatLng(".$row['lat'].",".$row['longitude']."),
";
  $check_food[$iter] = 0;
  $check_shelter[$iter] = 0;
  $check_service[$iter] = 0;
  $check_food[$iter] = in_array($row['organization_id'], $food);
  $check_shelter[$iter] = in_array($row['organization_id'], $shelter);
  $check_service[$iter] = in_array($row['organization_id'], $services);
  $check_police[$iter] = in_array($row['organization_id'], $police);
  $iter++;
      }
      echo "  ];";


        echo"
        var image_file = new Array();";
  for($i = 0; $i < count($info); $i++)
  {
  if($check_food[$i] == 1)
  {
  echo"
  image_file[".$i."] = 'http://labs.google.com/ridefinder/images/mm_20_purple.png';";
  }
  else if($check_shelter[$i] == 1)
  {
  echo"
  image_file[".$i."] = 'http://labs.google.com/ridefinder/images/mm_20_green.png';";
  }
  else if($check_service[$i] == 1)
  {
  echo"
  image_file[".$i."] = 'http://labs.google.com/ridefinder/images/mm_20_yellow.png';";
  }
  else if($check_police[$i] == 1)
  {
  echo"
  image_file[".$i."] = 'http://labs.google.com/ridefinder/images/mm_20_red.png';";
  }
  else
  {
  echo"
  image_file[".$i."] = 'http://labs.google.com/ridefinder/images/mm_20_blue.png';";
  }
  }
  echo "
  var marker = new google.maps.Marker({
    position: latlng1[0],
    map: map
  });
  attachMessage(marker, -1);
  
  for(var i = 0; i < ".count($info)."; i++)
  {
    var image = image_file[i];
    var marker = new google.maps.Marker({
      position: latlng1[i+1],
      map: map,
      icon: image
    });

    attachMessage(marker, i);
  }

  function attachMessage(marker, number)
  {
    var message = [";
    for($i = 0; $i < count($info); $i++)
    {
        echo "\"<a href='http://disaster.stjoe-redcross.org/organizationinfo.php?id=".$info[$i]['organization_id']."' target='_blank'>".$info[$i]['organization_name']."</a>\", 
";
    }
    echo "];
";

    echo "
    if(number != -1)
    {
        var infowindow = new google.maps.InfoWindow(
            { content: message[i]
            });
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map,marker);
        });
    }
    else
    {
        var infowindow = new google.maps.InfoWindow(
            { content: 'Searched'
            });
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map,marker);
        });
    }
  }

";
   echo "
}
</script>
    ";
}
echo "<title>St. Joseph Red Cross - Search</title>";
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="copyright" content="stjoe-redcross.org 2008.  All rights reserved.">
<link rel="shortcut icon" href="http://disaster.stjoe-redcross.org/favicon.ico">
<link rel="stylesheet" type="text/css" href="/style.css">

<body class="main" onload="initialize()">
	<div style="border:0px; background-color: #fff; padding: 0px">
		<div align="center" class="header">
			<img src="/masthead.jpg" style="width: 740px; height: 100px" alt="American Red Cross">
		</div>
		
		<div style="background-color: #000; padding: 5px; margin: 0px; color: #fff; height: 40px">
			<div style="float: left;">
				<b>American Red Cross, St. Joseph County Chapter</b><br />
				3220 East Jefferson Boulevard, South Bend IN 46615
			</div>
			
			<div style="float: right;">
				<b>Phone: (574) 234-0191</b><br />
				<a class="whitelink" 
                href="http://disaster.stjoe-redcross.org">
                http://disaster.stjoe-redcross.org
                </a>
			</div>
		</div>
        <!-- TABLE TO MANAGE OVERALL SITE DESIGN -->
		<table style="padding: 0px; margin: 0px; border: 0px;" cellpadding=0 cellspacing=0>
		<tr>
		<td style="background-color: #222; width: 740px; border: 0px">
<?php
echo html_navmenu(); //print out the navigation menu from functions.php.  Ensure that functions.php is called before this file!
?>
		</td>
		</tr>
		<tr>
		<td>
<?php

// Search form
if(($state == NULL || $state == "") && ($zip == NULL || $zip == ""))
{
    echo "<form name=\"Form1\" action=\"geo_search.php\" target=\"_self\" method=\"post\">
        <table>
        <tr><td>Street Address:</td><td><input type=\"text\" name=\"street_address\" />  </td></tr>
        <tr><td> City:</td><td><input type=\"text\" name=\"city\" />  </td></tr>
        <tr><td> State (Abbrev):</td><td><input type=\"text\" name=\"state\" /> </td></tr>
        <tr><td><b>OR</b></td></tr>
        <tr><td>Zip Code:</td><td><input type=\"text\" name=\"zip\" /> </td></tr>
        <tr><td><br /></td></tr>
        <tr><td><b>Distance</b></td>
            <td><CENTER><select name=\"distance\" id=\"distance\">
                    <option value=\"1\">1 mile</option>
                    <option value=\"5\">5 miles</option>
                    <option value=\"10\">10 miles</option>
                    <option value=\"20\" selected=\"selected\">20 miles</option>
                    <option value=\"50\">50 miles</option>
                </select></CENTER></td></tr>
        <tr><td></td><td><CENTER><input type=\"submit\">  </CENTER></td></tr>
        </table>
    </form>";
}
// else show results
else
{

echo "
<CENTER><div id=\"map_canvas\" style=\"width:650px; height:500px;\"></div><CENTER>
";
echo "<CENTER>MAP KEY<br /><img src='http://labs.google.com/ridefinder/images/mm_20_purple.png'> Food &nbsp &nbsp &nbsp <img src='http://labs.google.com/ridefinder/images/mm_20_green.png'> Shelter &nbsp &nbsp &nbsp <img src='http://labs.google.com/ridefinder/images/mm_20_yellow.png'> Social Services &nbsp &nbsp &nbsp <img src='http://labs.google.com/ridefinder/images/mm_20_red.png'> Police & Fire <img src='http://labs.google.com/ridefinder/images/mm_20_blue.png'> Other<br />";
$query = "SELECT *
FROM organization
WHERE SQRT( ( 69.1 * ( lat - ".$lat." ) ) * ( 69.1 * ( lat - ".$lat." ) ) + ( 53.0 * ( longitude - ".$longitude." ) ) * ( 53.0 * ( longitude - ".$longitude." ) ) ) < ".$distance."
ORDER BY SQRT( ( 69.1 * ( lat - ".$lat." ) ) * ( 69.1 * ( lat - ".$lat." ) ) + ( 53.0 * ( longitude - ".$longitude." ) ) * ( 53.0 * ( longitude - ".$longitude." ) ) )  ASC";

$result = mysql_query($query) or die ("Search query did not run correctly. Please try again.");


echo "<CENTER><table><b><h1>Nearby Locations</b></h1>";
while ( $row = mysql_fetch_assoc($result) ) {
$math = sqrt( ( 69.1 * ( $lat - $row['lat'] ) ) * ( 69.1 * ( $lat - $row['lat'] ) ) + ( 53.0 * ( $longitude - $row['longitude'] ) ) * ( 53.0 * ( $longitude - $row['longitude'] ) ) ); 
    echo "<tr><td><b><a href=\"http://disaster.stjoe-redcross.org/organizationinfo.php?id=".$row['organization_id']."\">".$row['organization_name']."</a></b></td></tr>
<tr><td>Street Address:</td><td>".$row['street_address']."</td></tr>
<tr><td>City, State:</td><td>".$row['city']." ".$row['state']."</td></tr>
<tr><td>Business Phone:</td><td>".$row['business_phone']."</td></tr>
<tr><td>24 Hour Phone:</td><td>".$row['24_hour_phone']."</td></tr>
<tr><td>Distance:</td><td> ".number_format($math, 3)." mi.</td></tr>";

}


}
	   

include ("./config/closedb.php");

include("./html_include_3.php");


?>
