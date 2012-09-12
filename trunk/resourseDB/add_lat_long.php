<?php

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
echo "<title>St. Joseph Red Cross - Search Results</title>";
include("./html_include_2.php");

$query =    "SELECT organization_id, street_address, city, county, state, zip
            FROM    organization";

$result = mysql_query($query) or die ("Search query did not run correctly. Please try again.");

$num_results = mysql_num_rows($result);
	
	print "<table>";
	print "<tr>";
	print "</tr>";

$contents = array();
	
	while ( $row_orig = mysql_fetch_assoc($result) ) {
	$row = str_replace(" ","+",$row_orig); 
		/*print "<tr>";
		print "<td>";
		print "<a href=\"../organizationinfo.php?id=".$row['organization_id']."\">".
			   $row['organization_name']."</a></b><br>".
			   $row['street_address']."<br />".
			   $row['city'].", ".$row['state']." ".$row['zip']."<br />".
			   $row['county']." County<br />".
               $row['state']." State<br />".
               $row['zip']." Zip Code<br />";
		print "</td>";
        print "</tr>";
        }
    print "</table>";*/
	

$search_url = 'http://maps.google.com/maps/api/geocode/json?address='.$row['street_address'].'+'.$row['city'].',+'.$row['state'].'&sensor=false';


$geocode=file_get_contents($search_url);

$output= json_decode($geocode);

$lat = $output->results[0]->geometry->location->lat;
$long = $output->results[0]->geometry->location->lng;
$contents[$row['organization_id']]["lat"] = $lat;
$contents[$row['organization_id']]["long"] = $long;

echo $lat, $long;

if($lat >= 38 && $lat <= 46 && $long <= -81 && $long >= -90)
{
    echo "Adding... ".$row['organization_id']." ".$contents[$row['organization_id']]["lat"]." ".$contents[$row['organization_id']]["long"]."<br />";

    $query2 =   'UPDATE organization
                 SET lat = '.$lat.'
                 WHERE organization_id = '.$row['organization_id'].'';
    $query3 =   'UPDATE organization
                 SET longitude = '.$long.'
                 WHERE organization_id = '.$row['organization_id'].'';
    echo $query2.'<br />';
    echo $query3.'<br />';
    $result2 = mysql_query($query2) or die ("Update lat query did not run correctly. Please try again.");
    $result3 = mysql_query($query3) or die ("Update long query did not run correctly. Please try again.");
}
else
{
    echo "Problem with coordinates. Adding... ";

    $query2 =   'UPDATE organization
                 SET lat = 41.703438
                 WHERE organization_id = '.$row['organization_id'].'';
    $query3 =   'UPDATE organization
                 SET longitude = -86.237247
                 WHERE organization_id = '.$row['organization_id'].'';
    echo $query2.'<br />';
    echo $query3.'<br />';
    $result2 = mysql_query($query2) or die ("Update lat query did not run correctly. Please try again.");
    $result3 = mysql_query($query3) or die ("Update long query did not run correctly. Please try again.");
}

}	   	   

include ("./config/closedb.php");

include("./html_include_3.php");


?>
